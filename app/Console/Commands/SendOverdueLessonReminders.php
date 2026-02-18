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
        $today = \Carbon\Carbon::now()->setTime(0, 0, 0); // Ignore time, just compare dates

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

            // Check if the entire course is expired based on the last lesson's date
            $maxFechaFinal = null;
            foreach ($schedule as $item) {
                if (isset($item['fecha_final'])) {
                    try {
                        $fecha = \Carbon\Carbon::createFromFormat('d/m/Y', $item['fecha_final'])->setTime(0, 0, 0);
                        if ($maxFechaFinal === null || $fecha->gt($maxFechaFinal)) {
                            $maxFechaFinal = $fecha;
                        }
                    } catch (\Exception $e) {
                         continue;
                    }
                }
            }

            // If we have a max date and today is past it, skip this course (it's expired)
            // Unless the user explicitly wants to notify about *any* uncompleted lesson even if course is over?
            // "si todas sus lecciones ya estan expiradas en tiempo entonces ya no notifiquemos" -> If today > max_date, skip.
            if ($maxFechaFinal && $today->gt($maxFechaFinal)) {
                $this->info("Course {$curso->id} is expired (End date: {$maxFechaFinal->format('d/m/Y')}). Skipping.");
                continue;
            }

            // 3. Get Enrolled Students
            $inscritos = $curso->Inscritos()->wherePivot('aceptado', 'si')->get();

            foreach ($inscritos as $user) {
                if (!$user) continue;

                // Get completed lesson IDs for this user in this course
                $completedLessonIds = $user->completedLessons()
                    ->wherePivot('curso_programado_id', $curso->id)
                    ->pluck('lecciones.id') // Specify table name to avoid ambiguity if needed, usually 'id' works on relationship
                    ->toArray();

                $overdueLessons = [];

                // 4. Check against schedule (Modules)
                foreach ($curso->Curso->Lecciones as $modulo) {
                    // Find module in schedule
                    $scheduleItem = $schedule->firstWhere('id', $modulo->id);

                    if ($scheduleItem && isset($scheduleItem['fecha_final'])) {
                        // Parse date (d/m/Y)
                        try {
                            $fechaFinal = \Carbon\Carbon::createFromFormat('d/m/Y', $scheduleItem['fecha_final'])->setTime(0, 0, 0);
                        } catch (\Exception $e) {
                            continue; // Invalid date format
                        }

                        // If Module is overdue
                        if ($today->gt($fechaFinal)) {
                            // Check lessons within this module
                            foreach ($modulo->Clases as $clase) {
                                if (!in_array($clase->id, $completedLessonIds)) {
                                    $overdueLessons[] = [
                                        'titulo' => $clase->titulo,
                                        'modulo' => $modulo->titulo,
                                        'fecha_final' => $scheduleItem['fecha_final']
                                    ];
                                }
                            }
                        }
                    }
                }

                // 5. Send Email and Notification if there are overdue lessons
                if (count($overdueLessons) > 0) {
                   \Illuminate\Support\Facades\Mail::to($user)->queue(new \App\Mail\OverdueLessonsReminder($overdueLessons, $user));
                   $this->info("Email queued for user: {$user->email}");

                   // Send UI Notification for each overdue lesson (or one summary?)
                   // The user requested: "un icono de notificaciones el cual le diga que lecciones tiene atrasadas"
                   // and "deberia poder al darle clic redireccionarle a la leccion en cuestion"
                   // So it's better to store each overdue lesson as a notification, OR a summary that links to the course.
                   // "redireccionarle a la leccion en cuestion" -> implies individual notifications per lesson.
                   
                   foreach ($overdueLessons as $lesson) {
                        // Check if already notified recently? For now, we just notify. 
                        // To avoid spamming daily for the same lesson, we might want to check DB. 
                        // But for "daily reminders", maybe it's intended.
                        // Let's check if a similar notification exists to avoid duplicates if run multiple times?
                        // For MVP, we send it. The user said "automatizar".

                       $user->notify(new \App\Notifications\OverdueLessonNotification($lesson));
                   }
                }
            }
        }
        
        $this->info('Overdue lesson checks completed.');
    }
}
