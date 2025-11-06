<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // First, try to login as admin (User model)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
            }
            
            // Regular user (not admin)
            return redirect()->route('home')->with('success', 'Welcome back!');
        }

        // If admin login fails, try student login (Registration model)
        $student = Registration::where('email', $credentials['email'])->first();

        if ($student && Hash::check($credentials['password'], $student->password)) {
            // Check if course is unlocked
            if (!$student->course_unlocked) {
                return back()->withErrors([
                    'email' => 'Your course access is pending. Please wait for admin approval.'
                ])->withInput();
            }

            // Store student info in session
            Session::put('student_id', $student->id);
            Session::put('student_name', $student->name);
            Session::put('student_email', $student->email);
            Session::put('student_course_id', $student->course_id);

            return redirect()->route('student.dashboard')->with('success', 'Welcome back, ' . $student->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->withInput();
    }

    public function logout(Request $request)
    {
        // Check if it's a student logout
        if (Session::has('student_id')) {
            Session::forget(['student_id', 'student_name', 'student_email', 'student_course_id']);
            return redirect()->route('login')->with('success', 'Logged out successfully!');
        }

        // Admin/User logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}
