<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== OTP RECORDS IN DATABASE ===\n\n";

$otps = DB::table('password_reset_otps')
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();

if ($otps->isEmpty()) {
    echo "No OTP records found.\n";
} else {
    foreach ($otps as $otp) {
        echo "Email: {$otp->email}\n";
        echo "OTP: {$otp->otp}\n";
        echo "Expires At: {$otp->expires_at}\n";
        echo "Used: " . ($otp->used ? 'Yes' : 'No') . "\n";
        echo "Created: {$otp->created_at}\n";
        echo "---\n";
    }
}

echo "\nCurrent Time: " . now() . "\n";
