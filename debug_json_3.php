<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$curso_programado = \App\Models\Registro\CursoProgramado::has('Curso.Lecciones.Clases')->first();
$contenidos = \App\Models\Registro\ContenidoProgramado::where('curso_programado_id', $curso_programado->id)->first();
$schedule = collect($contenidos->contenido);

foreach($curso_programado->Curso->Lecciones as $modulo) {
    echo "Modulo ID: " . $modulo->id . "\n";
    $m_item = $schedule->firstWhere('id', $modulo->id);
    if ($m_item) echo "  - M_fecha_final: " . ($m_item['fecha_final'] ?? 'N/A') . "\n";
    
    foreach($modulo->Clases as $clase) {
        $c_item = $schedule->firstWhere('id', $clase->id);
        echo "  Clase ID: " . $clase->id . " -> C_fecha_final: " . ($c_item['fecha_final'] ?? 'N/A') . "\n";
    }
}
