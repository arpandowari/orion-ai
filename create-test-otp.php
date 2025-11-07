<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Carbon\Carbon;

$email = $argv[1] ?? 'test@admin.com';

// Delete old OTPs for this email
DB::table('password_reset_otps')->where('email', $email)->delete();

// Generate new OTP
$otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

// Create new OTP
DB::table('password_reset_otps')->insert([
    'email' => $email,
    'otp' => $otp,
    'expires_at' => Carbon::now()->addMinutes(10),
    'used' => false,
    'created_at' => now(),
    'updated_at' => now()
]);

echo "=== TEST OTP CREATED ===\n\n";
echo "Email: {$email}\n";
echo "OTP: {$otp}\n";
echo "Expires: " . Carbon::now()->addMinutes(10) . "\n";
echo "\nUse this OTP to test the password reset flow.\n";
