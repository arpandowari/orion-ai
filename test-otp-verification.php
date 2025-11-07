<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Carbon\Carbon;

// Get the latest OTP
$latest = DB::table('password_reset_otps')
    ->orderBy('created_at', 'desc')
    ->first();

if (!$latest) {
    echo "No OTP records found. Please request a password reset first.\n";
    exit;
}

echo "=== LATEST OTP RECORD ===\n\n";
echo "Email: {$latest->email}\n";
echo "OTP: {$latest->otp}\n";
echo "Expires At: {$latest->expires_at}\n";
echo "Used: " . ($latest->used ? 'Yes' : 'No') . "\n";
echo "Created: {$latest->created_at}\n\n";

echo "=== VERIFICATION TEST ===\n\n";

$now = Carbon::now();
$expiresAt = Carbon::parse($latest->expires_at);

echo "Current Time: {$now}\n";
echo "Expires At: {$expiresAt}\n";
echo "Is Expired? " . ($expiresAt->isPast() ? 'Yes' : 'No') . "\n";
echo "Is Used? " . ($latest->used ? 'Yes' : 'No') . "\n\n";

// Test the query
$testEmail = $latest->email;
$testOtp = $latest->otp;

echo "=== TESTING QUERY ===\n";
echo "Looking for: Email={$testEmail}, OTP={$testOtp}\n\n";

$result = DB::table('password_reset_otps')
    ->where('email', $testEmail)
    ->where('otp', $testOtp)
    ->where('used', false)
    ->where('expires_at', '>', Carbon::now())
    ->first();

if ($result) {
    echo "✓ Query would SUCCEED - OTP is valid\n";
} else {
    echo "✗ Query would FAIL - OTP is invalid\n";
    
    // Check each condition
    echo "\nChecking conditions:\n";
    
    $emailMatch = DB::table('password_reset_otps')->where('email', $testEmail)->where('otp', $testOtp)->first();
    echo "1. Email + OTP match: " . ($emailMatch ? "✓ Yes" : "✗ No") . "\n";
    
    if ($emailMatch) {
        echo "2. Used = false: " . (!$emailMatch->used ? "✓ Yes" : "✗ No (used={$emailMatch->used})") . "\n";
        echo "3. Not expired: " . (Carbon::parse($emailMatch->expires_at)->isFuture() ? "✓ Yes" : "✗ No") . "\n";
    }
}
