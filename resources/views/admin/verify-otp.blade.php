@extends('layouts.app')

@section('title', 'Verify Admin OTP - ORION AI')

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
        text-align: center;
        letter-spacing: 8px;
        font-size: 1.5rem;
        font-family: 'Courier New', monospace;
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
        text-align: center;
    }

    .success-message {
        background: #d1fae5;
        color: #065f46;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        text-align: center;
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

    .email-display {
        background: #f8fafc;
        padding: 0.75rem;
        border-radius: 8px;
        text-align: center;
        margin-bottom: 1.5rem;
        font-weight: 600;
        color: var(--primary);
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>✉️ Verify Admin OTP</h1>
            <p>Enter the 6-digit code sent to your email</p>
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="email-display">
            📧 {{ session('admin_email') }}
        </div>

        <div class="info-box">
            ⏱️ OTP is valid for 10 minutes
        </div>

        <form method="POST" action="{{ route('admin.verify-otp.submit') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('admin_email') }}">

            <div class="form-group">
                <label for="otp">Enter OTP</label>
                <input type="text" id="otp" name="otp" maxlength="6" pattern="[0-9]{6}" required autofocus placeholder="000000">
                @error('otp')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="login-button">
                Verify OTP
            </button>
        </form>

        <div class="register-link">
            Didn't receive the code? <a href="{{ route('admin.forgot-password') }}">Resend OTP</a>
        </div>

        <div class="register-link">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</div>

<script>
    let isSubmitting = false;
    
    // Auto-submit when 6 digits are entered
    document.getElementById('otp').addEventListener('input', function(e) {
        if (e.target.value.length === 6 && !isSubmitting) {
            isSubmitting = true;
            e.target.form.submit();
        }
    });
    
    // Prevent double submission on button click
    document.querySelector('form').addEventListener('submit', function(e) {
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }
        isSubmitting = true;
    });
</script>
@endsection
