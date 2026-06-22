<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', 1);

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\User;
use Illuminate\Support\Facades\Hash;

$username = 'marencocode';
$password = 'marencos6359:D';

try {
    echo "Finding user...\n";
    $user = User::where('username', $username)->first();
    if (!$user) {
        echo "User not found!\n";
        exit;
    }
    echo "User found: " . $user->email . "\n";
    
    echo "Checking password...\n";
    $check = Hash::check($password, $user->password);
    echo "Password check: " . ($check ? 'VALID' : 'INVALID') . "\n";
    
    if ($check) {
        echo "Generating api_token...\n";
        if (!$user->api_token) {
            $user->api_token = \Illuminate\Support\Str::random(80);
            $user->save();
            echo "Generated new token: " . $user->api_token . "\n";
        } else {
            echo "Existing token: " . $user->api_token . "\n";
        }
    }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . " LINE: " . $e->getLine() . "\n";
    echo "TRACE:\n" . $e->getTraceAsString() . "\n";
}
