<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminManagementController extends Controller
{
    private function checkAdmin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access');
        }
    }

    // List all admins
    public function index()
    {
        $this->checkAdmin();
        $admins = User::where('is_admin', true)->latest()->get();
        return view('admin.admins.index', compact('admins'));
    }

    // Show create admin form
    public function create()
    {
        $this->checkAdmin();
        return view('admin.admins.create');
    }

    // Store new admin
    public function store(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        $validated['is_admin'] = true;
        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $admin = User::create($validated);

        // Send welcome email with credentials
        $this->sendWelcomeEmail($admin, $request->password);

        return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully! Welcome email sent.');
    }

    // Show edit admin form
    public function edit($id)
    {
        $this->checkAdmin();
        $admin = User::findOrFail($id);
        
        if (!$admin->is_admin) {
            return redirect()->route('admin.admins.index')->with('error', 'User is not an admin');
        }

        return view('admin.admins.edit', compact('admin'));
    }

    // Update admin
    public function update(Request $request, $id)
    {
        $this->checkAdmin();

        $admin = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture
            if ($admin->profile_picture) {
                Storage::disk('public')->delete($admin->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $admin->update($validated);

        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully!');
    }

    // Show change password form
    public function showChangePasswordForm($id)
    {
        $this->checkAdmin();
        $admin = User::findOrFail($id);
        
        if (!$admin->is_admin) {
            return redirect()->route('admin.admins.index')->with('error', 'User is not an admin');
        }

        return view('admin.admins.change-password', compact('admin'));
    }

    // Change password
    public function changePassword(Request $request, $id)
    {
        $this->checkAdmin();

        $admin = User::findOrFail($id);

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin->password = Hash::make($validated['password']);
        $admin->save();

        // Send password change notification email
        $this->sendPasswordChangeEmail($admin);

        return redirect()->route('admin.admins.index')->with('success', 'Password changed successfully! Notification email sent.');
    }

    // Delete admin
    public function destroy($id)
    {
        $this->checkAdmin();

        $admin = User::findOrFail($id);

        // Prevent deleting yourself
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admins.index')->with('error', 'You cannot delete your own account!');
        }

        // Delete profile picture
        if ($admin->profile_picture) {
            Storage::disk('public')->delete($admin->profile_picture);
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully!');
    }

    // Show profile
    public function profile()
    {
        $this->checkAdmin();
        $admin = auth()->user();
        return view('admin.admins.profile', compact('admin'));
    }

    // Update own profile
    public function updateProfile(Request $request)
    {
        $this->checkAdmin();

        $admin = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Verify current password if changing password
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $admin->password = Hash::make($request->new_password);
        }

        // Handle profile picture
        if ($request->hasFile('profile_picture')) {
            if ($admin->profile_picture) {
                Storage::disk('public')->delete($admin->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->phone = $validated['phone'] ?? $admin->phone;
        if (isset($validated['profile_picture'])) {
            $admin->profile_picture = $validated['profile_picture'];
        }
        $admin->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    // Send verification email
    public function sendVerificationEmail($id)
    {
        $this->checkAdmin();

        $admin = User::findOrFail($id);

        if ($admin->email_verified_at) {
            return back()->with('error', 'Email is already verified!');
        }

        // Generate verification token
        $token = Str::random(64);
        
        // Store token in password_reset_tokens table (reusing for verification)
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $admin->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // Send verification email
        $this->sendEmailVerification($admin, $token);

        return back()->with('success', 'Verification email sent successfully!');
    }

    // Verify email
    public function verifyEmail(Request $request, $id, $token)
    {
        $admin = User::findOrFail($id);

        $record = \DB::table('password_reset_tokens')
            ->where('email', $admin->email)
            ->first();

        if (!$record || !Hash::check($token, $record->token)) {
            return redirect()->route('login')->with('error', 'Invalid verification link!');
        }

        $admin->email_verified_at = now();
        $admin->save();

        \DB::table('password_reset_tokens')->where('email', $admin->email)->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Email verified successfully!');
    }

    // Email sending methods
    private function sendWelcomeEmail($admin, $password)
    {
        $data = [
            'admin' => $admin,
            'password' => $password,
            'loginUrl' => route('login')
        ];

        Mail::send('emails.admin-welcome', $data, function ($message) use ($admin) {
            $message->to($admin->email)
                    ->subject('Welcome to ORION AI - Admin Account Created');
        });
    }

    private function sendPasswordChangeEmail($admin)
    {
        $data = ['admin' => $admin];

        Mail::send('emails.admin-password-changed', $data, function ($message) use ($admin) {
            $message->to($admin->email)
                    ->subject('Your Password Has Been Changed - ORION AI');
        });
    }

    private function sendEmailVerification($admin, $token)
    {
        $verificationUrl = route('admin.verify-email', ['id' => $admin->id, 'token' => $token]);
        $data = [
            'admin' => $admin,
            'verificationUrl' => $verificationUrl
        ];

        Mail::send('emails.admin-verify-email', $data, function ($message) use ($admin) {
            $message->to($admin->email)
                    ->subject('Verify Your Email Address - ORION AI');
        });
    }
}
