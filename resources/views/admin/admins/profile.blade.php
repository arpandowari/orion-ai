@extends('layouts.admin')

@section('title', 'My Profile - ORION AI')

@section('styles')
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        text-align: center;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        margin-bottom: 1rem;
    }

    .profile-header h1 {
        margin: 0;
        font-size: 2rem;
    }

    .profile-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
    }

    .profile-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .profile-card h2 {
        color: var(--primary);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--light);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--dark);
        font-weight: 600;
    }

    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-group input[type="file"] {
        padding: 0.5rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: var(--secondary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        background: var(--light);
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .info-item strong {
        color: var(--primary);
    }

    .badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <div class="profile-header">
        @if($admin->profile_picture)
            <img src="{{ asset('storage/' . $admin->profile_picture) }}" alt="{{ $admin->name }}" class="profile-avatar">
        @else
            <div class="profile-avatar" style="background: white; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: bold;">
                {{ strtoupper(substr($admin->name, 0, 1)) }}
            </div>
        @endif
        <h1>{{ $admin->name }}</h1>
        <p>{{ $admin->email }}</p>
    </div>

    <!-- Profile Information -->
    <div class="profile-card">
        <h2>Profile Information</h2>
        
        <div class="info-item">
            <strong>Name:</strong>
            <span>{{ $admin->name }}</span>
        </div>

        <div class="info-item">
            <strong>Email:</strong>
            <span>{{ $admin->email }}</span>
        </div>

        <div class="info-item">
            <strong>Email Verified:</strong>
            <span>
                @if($admin->email_verified_at)
                    <span class="badge badge-success">✓ Verified</span>
                @else
                    <span class="badge badge-warning">⚠ Not Verified</span>
                @endif
            </span>
        </div>

        <div class="info-item">
            <strong>Account Created:</strong>
            <span>{{ $admin->created_at->format('M d, Y') }}</span>
        </div>

        <div class="info-item">
            <strong>Last Updated:</strong>
            <span>{{ $admin->updated_at->format('M d, Y H:i') }}</span>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="profile-card">
        <h2>Edit Profile</h2>
        
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                @error('name')
                    <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                @error('email')
                    <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="profile_picture">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                @error('profile_picture')
                    <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
                <small style="color: #64748b; display: block; margin-top: 0.25rem;">Max size: 2MB. Formats: JPG, PNG, GIF</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Change Password -->
    <div class="profile-card">
        <h2>Change Password</h2>
        
        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password">
                @error('current_password')
                    <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password">
                @error('password')
                    <span style="color: #ef4444; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
                <small style="color: #64748b; display: block; margin-top: 0.25rem;">Minimum 8 characters</small>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Change Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
