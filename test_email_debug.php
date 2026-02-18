<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "Attempting to send test email...\n";
try {
    Mail::raw('This is a test email to verify configuration.', function($msg) { 
        $msg->to('test@example.com')->subject('Test Email Verification'); 
    });
    echo "Email sent successfully.\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
