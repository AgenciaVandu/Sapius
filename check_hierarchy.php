<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cursos\Leccion;

$module = Leccion::find(615);
if ($module) {
    echo "Module ID: {$module->id}, Title: {$module->titulo}, Parent ID (leccion_id): {$module->leccion_id}\n";
    $parent = Leccion::find($module->leccion_id);
    if ($parent) {
        echo "Parent Title: {$parent->titulo}, Parent ID: {$parent->id}, Grandparent ID: {$parent->leccion_id}\n";
    } else {
        echo "This is a top-level module.\n";
    }
} else {
    echo "Module 615 not found.\n";
}
