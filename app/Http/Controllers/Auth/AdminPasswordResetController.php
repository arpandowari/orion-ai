<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordResetOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AdminPasswordResetController extends Controller
{
    // Show forgot password form
    public function showForgotPasswordForm()
    {
        return view('admin.forgot-password');
    }

    // Send OTP to admin email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $admin = User::where('email', $request->email)
            ->where('is_admin', true)
            ->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'No admin account found with this email address.']);
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete old OTPs for this email
        PasswordResetOtp::where('email', $request->email)->delete();

        // Create new OTP
        PasswordResetOtp::create([
            'email' => $request->email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
            'used' => false
        ]);

        // Send email
        try {
            Mail::send('emails.admin-password-reset-otp', ['otp' => $otp], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Admin Password Reset OTP - ORION AI');
            });

            // Store email in session for the entire password reset flow
            session()->put('admin_email', $request->email);

            return redirect()->route('admin.verify-otp')->with('success', 'OTP has been sent to your admin email address.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }
    }

    // Show verify OTP form
    public function showVerifyOtpForm()
    {
        if (!session('admin_email')) {
            return redirect()->route('admin.forgot-password')->withErrors(['error' => 'Please enter your email first.']);
        }

        return view('admin.verify-otp');
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6'
        ]);

        // Check if OTP exists for this email
        $otpExists = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$otpExists) {
            return back()->withErrors(['otp' => 'Invalid OTP code. Please check and try again.']);
        }

        if ($otpExists->used) {
            return back()->withErrors(['otp' => 'This OTP has already been used. Please request a new one.']);
        }

        if (Carbon::parse($otpExists->expires_at)->isPast()) {
            return back()->withErrors(['otp' => 'This OTP has expired. Please request a new one.']);
        }

        $otpRecord = $otpExists;

        // Mark OTP as used
        $otpRecord->update(['used' => true]);

        // Store verification status in session
        session()->put('admin_otp_verified', true);

        return redirect()->route('admin.reset-password')->with('success', 'OTP verified successfully. Please set your new password.');
    }

    // Show reset password form
    public function showResetPasswordForm()
    {
        if (!session('admin_otp_verified')) {
            return redirect()->route('admin.forgot-password')->withErrors(['error' => 'Please verify OTP first.']);
        }

        return view('admin.reset-password');
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        if (!session('admin_otp_verified')) {
            return redirect()->route('admin.forgot-password')->withErrors(['error' => 'Unauthorized access.']);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        $admin = User::where('email', $request->email)
            ->where('is_admin', true)
            ->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'Admin not found.']);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        // Send notification email
        try {
            Mail::send('emails.admin-password-changed', ['admin' => $admin], function ($message) use ($admin) {
                $message->to($admin->email)
                    ->subject('Admin Password Changed - ORION AI');
            });
        } catch (\Exception $e) {
            // Continue even if email fails
        }

        // Clear session
        $request->session()->forget(['admin_email', 'admin_otp_verified']);

        return redirect()->route('login')->with('success', 'Admin password reset successfully! You can now login with your new password.');
    }
}
