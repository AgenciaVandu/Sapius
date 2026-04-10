<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\User;

$username = 'marencocode';
$user = User::where('username', $username)->first();

if (!$user) die("User not found");

echo "Notifications for {$user->nombre}:\n";
foreach ($user->notifications()->take(20)->get() as $n) {
    echo "Type: {$n->type}\n";
    echo "Data: " . json_encode($n->data) . "\n";
    echo "Created: {$n->created_at}\n";
    echo "-------------------\n";
}
