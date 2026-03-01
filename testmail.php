<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

config(['queue.default' => 'sync']);
$user = new App\User();
$user->nombre = 'Estudiante de Prueba';
$user->email = 'test@sapius.com.mx';
$overdueLessons = [
    ['titulo' => 'Introducción a la Biología Molecular', 'modulo' => 'Módulo 1: Conceptos Básicos', 'fecha_final' => '15/05/2026 23:59'],
    ['titulo' => 'Estructura Celular Avanzada (Lección muy larga con un título extenso que rompía la tabla en dispositivos moviles)', 'modulo' => 'Módulo 2: Células', 'fecha_final' => '20/05/2026 23:59']
];
\Mail::to($user)->send(new \App\Mail\OverdueLessonsReminder($overdueLessons, $user));
echo "Correo de prueba enviado a Mailtrap exitosamente.\n";
