@extends('layouts.app')

@section('title', 'Login - ORION AI')

@section('styles')
<style>
    .login-container {
        max-width: 500px;
        margin: 3rem auto;
        background: white;
        padding: 3rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
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
        font-size: 1rem;
    }

    .user-type-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        background: #f1f5f9;
        padding: 0.5rem;
        border-radius: 10px;
    }

    .user-type-tab {
        flex: 1;
        padding: 0.75rem;
        text-align: center;
        border-radius: 8px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        background: transparent;
    }

    .user-type-tab.active {
        background: white;
        color: var(--primary);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--dark);
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

    .login-btn {
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

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .info-box {
        background: #eff6ff;
        border-left: 4px solid var(--secondary);
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1.5rem;
    }

    .info-box p {
        margin: 0;
        color: #1e40af;
        font-size: 0.875rem;
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

    .forgot-password-link {
        text-align: right;
        margin-bottom: 1.5rem;
        margin-top: -0.5rem;
    }

    .forgot-password-link a {
        color: var(--secondary);
        font-size: 0.875rem;
        text-decoration: none;
        font-weight: 500;
    }

    .forgot-password-link a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="login-container">
        <div class="login-header">
            <h1>Login to ORION AI</h1>
            <p>Access your dashboard and courses</p>
        </div>

        <div class="user-type-tabs">
            <div class="user-type-tab active" id="studentTab" onclick="switchTab('student')">
                Student
            </div>
            <div class="user-type-tab" id="adminTab" onclick="switchTab('admin')">
                Administrator
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <p style="margin: 0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}" autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="forgot-password-link" id="studentForgotPassword">
                <a href="{{ route('student.forgot-password') }}">Forgot Password?</a>
            </div>

            <div class="forgot-password-link" id="adminForgotPassword" style="display: none;">
                <a href="{{ route('admin.forgot-password') }}">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn">
                Login to Dashboard
            </button>
        </form>

        <div class="info-box" id="studentInfo">
            <p><strong>Students:</strong> Use the email and password you created during course registration.</p>
        </div>

        <div class="info-box" id="adminInfo" style="display: none;">
            <p><strong>Admins:</strong> Use your admin credentials to access the admin panel.</p>
        </div>

        <div class="register-link">
            Don't have an account? <a href="{{ route('courses.index') }}">Browse Courses & Register</a>
        </div>
    </div>
</div>

<script>
function switchTab(type) {
    const studentTab = document.getElementById('studentTab');
    const adminTab = document.getElementById('adminTab');
    const studentInfo = document.getElementById('studentInfo');
    const adminInfo = document.getElementById('adminInfo');
    const studentForgotPassword = document.getElementById('studentForgotPassword');
    const adminForgotPassword = document.getElementById('adminForgotPassword');

    if (type === 'student') {
        studentTab.classList.add('active');
        adminTab.classList.remove('active');
        studentInfo.style.display = 'block';
        adminInfo.style.display = 'none';
        studentForgotPassword.style.display = 'block';
        adminForgotPassword.style.display = 'none';
    } else {
        adminTab.classList.add('active');
        studentTab.classList.remove('active');
        adminInfo.style.display = 'block';
        studentInfo.style.display = 'none';
        studentForgotPassword.style.display = 'none';
        adminForgotPassword.style.display = 'block';
    }
}
</script>
@endsection
