<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendOverdueLessonReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:overdue-lessons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios a los alumnos con lecciones atrasadas.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = \Carbon\Carbon::now();

        $this->info("Checking for pending lessons on " . $now->format('d/m/Y H:i'));

        // 1. Get Active Courses
        $cursos = \App\Models\Registro\CursoProgramado::with(['Curso.Lecciones.Clases'])
            ->where('activo', 'si')
            ->get();

        foreach ($cursos as $curso) {
            // 2. Get content schedule
            $contenidoProgramado = \App\Models\Registro\ContenidoProgramado::where('curso_programado_id', $curso->id)->first();
            
            if (!$contenidoProgramado || !$contenidoProgramado->contenido) {
                continue;
            }

            $schedule = collect($contenidoProgramado->contenido);

            // Find the MAX course end date to check if the whole course appears expired
            $maxFechaFinal = null;
            foreach ($schedule as $item) {
                if (isset($item['fecha_final'])) {
                    try {
                        $format = 'd/m/Y';
                        $dateStr = $item['fecha_final'];
                        
                        if (isset($item['hora_final'])) {
                            $format .= ' H:i';
                            $dateStr .= ' ' . $item['hora_final'];
                        }
                        
                        $fecha = \Carbon\Carbon::createFromFormat($format, $dateStr);
                        
                        // If no time was present, set to end of day? Or Keep 00:00? 
                        // Usually end date implies until the end of that day.
                        if (!isset($item['hora_final'])) {
                            $fecha->setTime(23, 59, 59);
                        }

                        if ($maxFechaFinal === null || $fecha->gt($maxFechaFinal)) {
                            $maxFechaFinal = $fecha;
                        }
                    } catch (\Exception $e) { continue; }
                }
            }

            // If the COURSE is fully expired, skip it.
            if ($maxFechaFinal && $now->gt($maxFechaFinal)) {
                $this->info("Course {$curso->id} is expired (End date: {$maxFechaFinal->format('d/m/Y H:i')}). Skipping.");
                continue;
            }

            // 3. Get Enrolled Students
            $inscritos = $curso->Inscritos()->wherePivot('aceptado', 'si')->get();

            foreach ($inscritos as $user) {
                if (!$user) continue;

                // Get completed lessons logic (optional, but good practice if available)
                $completedLessonIds = $user->completedLessons()->wherePivot('curso_programado_id', $curso->id)->pluck('lecciones.id')->toArray();
                $submittedHomeworkLessonIds = clone (\App\Homework::class);
                $submittedHomeworkLessonIds = \App\Homework::where('user_id', $user->id)->pluck('leccion_id')->toArray();

                $pendingLessons = [];

                // 4. Check against schedule (Modules)
                foreach ($curso->Curso->Lecciones as $modulo) {
                    // Find module in schedule
                    $scheduleItem = $schedule->firstWhere('id', $modulo->id);

                    if ($scheduleItem && isset($scheduleItem['fecha_inicial']) && isset($scheduleItem['fecha_final'])) {
                        try {
                            // Parse Start Date + Time
                            $startFormat = 'd/m/Y';
                            $startStr = $scheduleItem['fecha_inicial'];
                            if (isset($scheduleItem['hora_inicial'])) {
                                $startFormat .= ' H:i';
                                $startStr .= ' ' . $scheduleItem['hora_inicial'];
                            }
                            $fechaInicial = \Carbon\Carbon::createFromFormat($startFormat, $startStr);

                            // Parse End Date + Time
                            $endFormat = 'd/m/Y';
                            $endStr = $scheduleItem['fecha_final'];
                            if (isset($scheduleItem['hora_final'])) {
                                $endFormat .= ' H:i';
                                $endStr .= ' ' . $scheduleItem['hora_final'];
                            }
                            $fechaFinal = \Carbon\Carbon::createFromFormat($endFormat, $endStr);
                            
                            // If user didn't specify time for end date, assume end of day
                            if (!isset($scheduleItem['hora_final'])) {
                                $fechaFinal->setTime(23, 59, 59);
                            }

                        } catch (\Exception $e) { continue; }

                        // Logic:
                        // 1. Lesson Started > 2 days ago? ($now >= $fechaInicial + 2 days)
                        // 2. Lesson Still Active? ($now <= $fechaFinal)
                        
                        $reminderStartDate = $fechaInicial->copy()->addDays(2);

                        if ($now->gte($reminderStartDate) && $now->lte($fechaFinal)) {
                             // This module is currently "active" for reminders.
                             // Add lessons to pending list.
                             foreach ($modulo->Clases as $clase) {
                                // Add logic here if we want to filter ONLY completed lessons
                                if (in_array($clase->id, $completedLessonIds) || in_array($clase->id, $submittedHomeworkLessonIds)) {
                                    continue; // Skip already completed or submitted
                                }

                                // For now, we list them as pending reminders.
                                $pendingLessons[] = [
                                    'titulo' => $clase->titulo, // Lesson Title
                                    'modulo' => $modulo->titulo, // Module Title
                                    'fecha_final' => $scheduleItem['fecha_final'] . (isset($scheduleItem['hora_final']) ? ' ' . $scheduleItem['hora_final'] : ''),
                                    'leccion_id' => $clase->id, // Passing ID for link
                                    'curso_programado_id' => $curso->id,
                                    'inscripcion_id' => $user->pivot->id ?? null
                                ];
                             }
                        }
                    }
                }

                // 5. Send Notification/Email
                if (count($pendingLessons) > 0) {
                    $this->info("Found " . count($pendingLessons) . " pending lessons for user: {$user->email}");

                    // Send Email
                    \Illuminate\Support\Facades\Mail::to($user)->queue(new \App\Mail\OverdueLessonsReminder($pendingLessons, $user));

                   // Send UI Notifications
                   foreach ($pendingLessons as $lessonData) {
                        // Avoid duplicates if logic allows, but for now we send.
                       $user->notify(new \App\Notifications\OverdueLessonNotification($lessonData));
                   }
                }
            }
        }
        
        $this->info('Reminder checks completed.');
    }
}
