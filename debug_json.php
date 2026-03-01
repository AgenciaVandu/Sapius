<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$contenidos = \App\Models\Registro\ContenidoProgramado::whereNotNull('contenido')->get();
foreach($contenidos as $c) {
    echo "ID: " . $c->id . "\n";
    echo json_encode($c->contenido, JSON_PRETTY_PRINT). "\n";
    echo "--------------------------\n";
}
