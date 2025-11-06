@extends('layouts.app')

@section('title', 'Student Login - ORION AI')

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
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>Student Login</h1>
            <p>Access your courses and track your progress</p>
        </div>

        <form method="POST" action="{{ route('student.login.submit') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="login-button">
                Login to Dashboard
            </button>
        </form>

        <div class="register-link">
            <a href="{{ route('student.forgot-password') }}">Forgot Password?</a>
        </div>

        <div class="register-link">
            Don't have an account? <a href="{{ route('courses.index') }}">Browse Courses</a>
        </div>
    </div>
</div>
@endsection
