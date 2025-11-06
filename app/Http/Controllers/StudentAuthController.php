<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\VideoProgress;
use App\Models\PasswordResetOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class StudentAuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('student.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to login using the student guard
        if (auth()->guard('student')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $student = auth()->guard('student')->user();
            
            return redirect()->route('student.dashboard')->with('success', 'Welcome back, ' . $student->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        auth()->guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('student.login')->with('success', 'Logged out successfully!');
    }

    // Dashboard
    public function dashboard()
    {
        if (!auth()->guard('student')->check()) {
            return redirect()->route('student.login')->with('error', 'Please login to access your dashboard');
        }

        $student = auth()->guard('student')->user()->load('course.videos');
        
        // Get completed videos
        $completedVideos = VideoProgress::where('user_id', $student->id)
            ->where('completed', true)
            ->get();

        // Calculate progress
        $totalVideos = $student->course->videos->count();
        $completedCount = $completedVideos->count();
        $progressPercentage = $totalVideos > 0 ? round(($completedCount / $totalVideos) * 100) : 0;
        $courseCompleted = $totalVideos > 0 && $completedCount === $totalVideos;

        return view('student.dashboard', compact('student', 'completedVideos', 'totalVideos', 'completedCount', 'progressPercentage', 'courseCompleted'));
    }

    // Profile
    public function profile()
    {
        if (!auth()->guard('student')->check()) {
            return redirect()->route('student.login')->with('error', 'Please login to access your profile');
        }

        $student = auth()->guard('student')->user()->load('course');
        
        // Get completed videos with details
        $completedVideos = VideoProgress::where('user_id', $student->id)
            ->where('completed', true)
            ->with('video')
            ->get();

        // Calculate progress
        $totalVideos = $student->course->videos->count();
        $completedCount = $completedVideos->count();
        $progressPercentage = $totalVideos > 0 ? round(($completedCount / $totalVideos) * 100) : 0;
        $courseCompleted = $totalVideos > 0 && $completedCount === $totalVideos;

        return view('student.profile', compact('student', 'completedVideos', 'totalVideos', 'completedCount', 'progressPercentage', 'courseCompleted'));
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        if (!auth()->guard('student')->check()) {
            return redirect()->route('student.login')->with('error', 'Please login to update your profile');
        }

        $student = auth()->guard('student')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:registrations,email,' . $student->id,
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Verify current password if changing password
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $student->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $student->password = Hash::make($request->new_password);
        }

        // Handle profile picture
        if ($request->hasFile('profile_picture')) {
            if ($student->profile_picture) {
                \Storage::disk('public')->delete($student->profile_picture);
            }
            $student->profile_picture = $request->file('profile_picture')->store('student_profiles', 'public');
        }

        $student->name = $validated['name'];
        $student->email = $validated['email'];
        $student->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    // Show forgot password form
    public function showForgotPasswordForm()
    {
        return view('student.forgot-password');
    }

    // Send OTP to email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $student = Registration::where('email', $request->email)->first();

        if (!$student) {
            return back()->withErrors(['email' => 'No account found with this email address.']);
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
            Mail::send('emails.student-password-reset-otp', ['otp' => $otp], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Password Reset OTP - ORION AI');
            });

            // Store email in session for the entire password reset flow
            session()->put('email', $request->email);

            return redirect()->route('student.verify-otp')->with('success', 'OTP has been sent to your email address.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }
    }

    // Show verify OTP form
    public function showVerifyOtpForm()
    {
        if (!session('email')) {
            return redirect()->route('student.forgot-password')->withErrors(['error' => 'Please enter your email first.']);
        }

        return view('student.verify-otp');
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
        session()->put('otp_verified', true);

        return redirect()->route('student.reset-password')->with('success', 'OTP verified successfully. Please set your new password.');
    }

    // Show reset password form
    public function showResetPasswordForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('student.forgot-password')->withErrors(['error' => 'Please verify OTP first.']);
        }

        return view('student.reset-password');
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        if (!session('otp_verified')) {
            return redirect()->route('student.forgot-password')->withErrors(['error' => 'Unauthorized access.']);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        $student = Registration::where('email', $request->email)->first();

        if (!$student) {
            return back()->withErrors(['email' => 'Student not found.']);
        }

        $student->password = Hash::make($request->password);
        $student->save();

        // Clear session
        $request->session()->forget(['email', 'otp_verified']);

        return redirect()->route('student.login')->with('success', 'Password reset successfully! You can now login with your new password.');
    }
}
