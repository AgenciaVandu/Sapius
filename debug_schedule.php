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

$curso = CursoProgramado::with(['Curso.Lecciones' => function($r) {
    $r->with(['Clases' => function($c) {
        $c->where('activo', 'si');
    }]);
}])->find($cursoId);

$contenidoProgramado = ContenidoProgramado::where('curso_programado_id', $curso->id)->first();
$schedule = collect($contenidoProgramado->contenido);

foreach ($curso->Curso->Lecciones as $modulo) {
    $item = $schedule->firstWhere('id', $modulo->id);
    if ($item) {
        echo "Module: {$modulo->titulo} - ID: {$modulo->id}\n";
        echo "  Schedule Data: " . json_encode($item) . "\n";
    }
    foreach ($modulo->Clases as $clase) {
        $item = $schedule->firstWhere('id', $clase->id);
        if ($item) {
            echo "  Class: {$clase->titulo} - ID: {$clase->id}\n";
            echo "    Schedule Data: " . json_encode($item) . "\n";
        }
    }
}
