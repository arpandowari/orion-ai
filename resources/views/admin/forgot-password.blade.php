@extends('layouts.app')

@section('title', 'Admin Forgot Password - ORION AI')

@section('styles')
<style>
    .login-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .login-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        padding: 3rem;
        max-width: 450px;
        width: 100%;
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-header h1 {
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .login-header p {
        color: #64748b;
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
        padding: 0.875rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .login-button {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .login-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .register-link {
        text-align: center;
        margin-top: 1.5rem;
        color: #64748b;
    }

    .register-link a {
        color: var(--secondary);
        font-weight: 600;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    .info-box {
        background: #f0f9ff;
        border-left: 4px solid var(--secondary);
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        color: #0369a1;
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>🔐 Admin Password Reset</h1>
            <p>Enter your admin email to receive a verification code</p>
        </div>

        <div class="info-box">
            📧 We'll send a 6-digit OTP to your registered admin email address
        </div>

        <form method="POST" action="{{ route('admin.send-otp') }}">
            @csrf

            <div class="form-group">
                <label for="email">Admin Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@orionai.com">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="login-button">
                Send OTP
            </button>
        </form>

        <div class="register-link">
            Remember your password? <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</div>
@endsection
