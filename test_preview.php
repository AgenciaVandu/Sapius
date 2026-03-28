<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$now = \Carbon\Carbon::now();
$cursos = \App\Models\Registro\CursoProgramado::with(['Curso' => function($r) {
    $r->with(['Lecciones' => function($q) {
        $q->with(['Clases' => function($c) {
            $c->where('activo', 'si');
        }]);
        $q->where('leccion_id', 0)->where('activo', 'si');
    }]);
}])
->where('activo', 'si')
->get();

$html = "";
foreach ($cursos as $curso) {
    if (!$html && $curso->Inscritos()->count() > 0) {
        $contenidoProgramado = \App\Models\Registro\ContenidoProgramado::where('curso_programado_id', $curso->id)->first();
        if (!$contenidoProgramado || !$contenidoProgramado->contenido) continue;
        $schedule = collect($contenidoProgramado->contenido);

        $user = $curso->Inscritos()->where('nombre', 'like', '%Veronic%')->first();
        if (!$user) continue;

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
                    if (!isset($item['hora_final'])) {
                        $fecha->setTime(23, 59, 59);
                    }
                    if ($maxFechaFinal === null || $fecha->gt($maxFechaFinal)) {
                        $maxFechaFinal = $fecha;
                    }
                } catch (\Exception $e) { continue; }
            }
        }

        if ($maxFechaFinal && $now->gt($maxFechaFinal)) {
            continue; // Skip expired courses! We want a currently active one.
        }

        $pendingLessons = [];
        $completedLessonIds = $user->completedLessons()->wherePivot('curso_programado_id', $curso->id)->pluck('lecciones.id')->toArray();
        $submittedHomeworkLessonIds = \App\Homework::where('user_id', $user->id)->pluck('leccion_id')->toArray();

        foreach ($curso->Curso->Lecciones as $modulo) {
            $moduleScheduleItem = $schedule->firstWhere('id', $modulo->id);
            foreach ($modulo->Clases as $clase) {
                if (in_array($clase->id, $completedLessonIds) || in_array($clase->id, $submittedHomeworkLessonIds)) {
                     continue;
                 }

                // Fallback a modulo en BD si clase no tiene.
                $scheduleItem = $schedule->firstWhere('id', $clase->id) ?? $moduleScheduleItem;
                if ($scheduleItem && isset($scheduleItem['fecha_inicial']) && isset($scheduleItem['fecha_final'])) {
                    $fechaInicial = \Carbon\Carbon::createFromFormat('d/m/Y', explode(' ', $scheduleItem['fecha_inicial'])[0]);
                    
                    $endFormat = 'd/m/Y';
                    $endStr = $scheduleItem['fecha_final'];
                    if (isset($scheduleItem['hora_final'])) {
                        $endFormat .= ' H:i';
                        $endStr .= ' ' . $scheduleItem['hora_final'];
                    }
                    $fechaFinal = \Carbon\Carbon::createFromFormat($endFormat, $endStr);
                    if (!isset($scheduleItem['hora_final'])) {
                        $fechaFinal->setTime(23, 59, 59);
                    }

                    $reminderStartDate = $fechaInicial->copy()->addDays(2);
                    
                    if ($now->gte($reminderStartDate)) {
                        $pendingLessons[] = [
                            'titulo' => $clase->titulo,
                            'modulo' => $modulo->titulo,
                            'fecha_final' => $scheduleItem['fecha_final'] . (isset($scheduleItem['hora_final']) ? ' ' . $scheduleItem['hora_final'] : ''),
                            'is_expired' => $now->gt($fechaFinal),
                            'leccion_id' => $clase->id,
                            'curso_programado_id' => $curso->id,
                            'inscripcion_id' => $user->pivot->id ?? null
                        ];
                    }
                }
            }
        }
        
        if (count($pendingLessons) > 0) {
            $mail = new \App\Mail\OverdueLessonsReminder($pendingLessons, $user);
            $html = $mail->render();
            break;
        }
    }
}
file_put_contents('C:\Users\maren\.gemini\antigravity\brain\349f92f1-9781-4b0c-9fe5-884cfe72f5cf\preview.html', $html ?: "No pending lessons found to preview for Veronica.");
echo "Done";
