@extends('layouts.admin')

@section('title', 'Change Password - ORION AI')

@section('styles')
<style>
    .form-container {
        max-width: 500px;
        margin: 0 auto;
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }

    .form-container h1 {
        color: var(--primary);
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .admin-info {
        text-align: center;
        color: #64748b;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f1f5f9;
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
        transition: all 0.3s;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-group small {
        display: block;
        margin-top: 0.25rem;
        color: #64748b;
        font-size: 0.875rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .form-actions button,
    .form-actions a {
        flex: 1;
        padding: 0.875rem;
        border-radius: 8px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-submit {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-cancel {
        background: #e2e8f0;
        color: var(--dark);
    }

    .btn-cancel:hover {
        background: #cbd5e1;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="form-container">
        <h1>Change Password</h1>
        <div class="admin-info">
            <strong>{{ $admin->name }}</strong><br>
            {{ $admin->email }}
        </div>

        <form method="POST" action="{{ route('admin.admins.update-password', $admin->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="password">New Password *</label>
                <input type="password" id="password" name="password" required>
                <small>Minimum 8 characters</small>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password *</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.admins.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Change Password</button>
            </div>
        </form>
    </div>
</div>
@endsection
