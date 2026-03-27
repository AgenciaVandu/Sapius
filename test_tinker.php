<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$contenido = \App\Models\Registro\ContenidoProgramado::whereNotNull('contenido')->first();
if ($contenido) {
    echo json_encode($contenido->contenido, JSON_PRETTY_PRINT);
} else {
    echo "No content found";
}
