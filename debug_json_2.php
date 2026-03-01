<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$curso_programado = \App\Models\Registro\CursoProgramado::has('Curso.Lecciones.Clases')->first();
$contenidos = \App\Models\Registro\ContenidoProgramado::where('curso_programado_id', $curso_programado->id)->first();

echo "Curso ID: " . $curso_programado->curso_id . "\n";
foreach($curso_programado->Curso->Lecciones as $modulo) {
    echo "Modulo ID: " . $modulo->id . " nombre: " . $modulo->titulo . "\n";
    foreach($modulo->Clases as $clase) {
        echo "  Clase ID: " . $clase->id . " nombre: " . $clase->titulo . "\n";
    }
}
echo "\nJSON Contenido:\n";
echo json_encode($contenidos->contenido, JSON_PRETTY_PRINT). "\n";
