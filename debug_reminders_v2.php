<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\User;
use App\Models\Registro\CursoProgramado;
use App\Models\Registro\ContenidoProgramado;
use Carbon\Carbon;

$username = 'marencocode';
$user = User::where('username', $username)->first();
$cursoId = 150;

$curso = CursoProgramado::with(['Curso.Lecciones' => function($q) {
    $q->where('leccion_id', 0)->where('activo', 'si')->with(['Clases' => function($c) {
        $c->where('activo', 'si');
    }]);
}])->find($cursoId);

if (!$curso) die("Course $cursoId not found");

echo "Testing for User: {$user->nombre} (ID: {$user->id})\n";
$now = Carbon::now();
echo "Current Time: {$now->toDateTimeString()}\n\n";

echo "Checking Course: {$curso->Curso->titulo} (ID: {$curso->id})\n";

$contenidoProgramado = ContenidoProgramado::where('curso_programado_id', $curso->id)->first();
$schedule = collect($contenidoProgramado->contenido);

$completedLessonIds = $user->completedLessons()->wherePivot('curso_programado_id', $curso->id)->pluck('lecciones.id')->toArray();
$submittedHomeworkLessonIds = \App\Homework::where('user_id', $user->id)->pluck('leccion_id')->toArray();

foreach ($curso->Curso->Lecciones as $modulo) {
    $moduleScheduleItem = $schedule->firstWhere('id', $modulo->id);
    
    foreach ($modulo->Clases as $clase) {
        $isCompleted = in_array($clase->id, $completedLessonIds) || in_array($clase->id, $submittedHomeworkLessonIds);
        
        $scheduleItem = $schedule->firstWhere('id', $clase->id) ?? $moduleScheduleItem;
        
        if ($scheduleItem && isset($scheduleItem['fecha_inicial']) && isset($scheduleItem['fecha_final'])) {
            try {
                $startFormat = 'd/m/Y' . (isset($scheduleItem['hora_inicial']) ? ' H:i' : '');
                $startStr = $scheduleItem['fecha_inicial'] . (isset($scheduleItem['hora_inicial']) ? ' ' . $scheduleItem['hora_inicial'] : '');
                $fechaInicial = Carbon::createFromFormat($startFormat, $startStr);

                $endFormat = 'd/m/Y' . (isset($scheduleItem['hora_final']) ? ' H:i' : '');
                $endStr = $scheduleItem['fecha_final'] . (isset($scheduleItem['hora_final']) ? ' ' . $scheduleItem['hora_final'] : '');
                $fechaFinal = Carbon::createFromFormat($endFormat, $endStr);
                if (!isset($scheduleItem['hora_final'])) $fechaFinal->setTime(23, 59, 59);
                
                $reminderStartDate = $fechaInicial->copy()->addDays(2);
                $isOverdueLogic = $now->gte($reminderStartDate);
                $isExpired = $now->gt($fechaFinal);

                if (!$isCompleted) {
                    echo "  Lesson: {$clase->titulo}\n";
                    echo "    Start: {$fechaInicial->toDateTimeString()}\n";
                    echo "    End: {$fechaFinal->toDateTimeString()}\n";
                    echo "    Reminder Start: {$reminderStartDate->toDateTimeString()}\n";
                    echo "    Include In Reminder: " . ($isOverdueLogic ? "YES" : "NO") . "\n";
                    echo "    Status IF included: " . ($isExpired ? "CERRADA" : "ATRASADA") . "\n";
                    echo "-----------------------------------\n";
                }

            } catch (\Exception $e) {}
        }
    }
}
