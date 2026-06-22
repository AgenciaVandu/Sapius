<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Http\Request;
$request = Request::create('/api/login', 'POST', [
    'username' => 'marencocode',
    'password' => 'marencos6359:D'
]);

try {
    $response = $kernel->handle($request);
    echo "STATUS: " . $response->getStatusCode() . "\n";
    echo "CONTENT: " . $response->getContent() . "\n";
} catch (\Throwable $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    echo "FILE: " . $e->getFile() . " LINE: " . $e->getLine() . "\n";
    echo "TRACE:\n" . $e->getTraceAsString() . "\n";
}
