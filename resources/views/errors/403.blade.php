@extends('layouts.app')

@section('title', 'Access Denied - ORION AI')

@section('styles')
<style>
    .error-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .error-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        padding: 3rem;
        max-width: 600px;
        width: 100%;
        text-align: center;
    }

    .error-icon {
        font-size: 5rem;
        margin-bottom: 1rem;
    }

    .error-code {
        font-size: 4rem;
        font-weight: bold;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .error-title {
        font-size: 2rem;
        color: var(--dark);
        margin-bottom: 1rem;
    }

    .error-message {
        color: #64748b;
        font-size: 1.1rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .error-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-primary {
        padding: 0.875rem 2rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn-secondary {
        padding: 0.875rem 2rem;
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }

    .btn-secondary:hover {
        background: var(--primary);
        color: white;
    }

    .info-box {
        background: #f0f9ff;
        border-left: 4px solid var(--secondary);
        padding: 1rem;
        border-radius: 8px;
        margin-top: 2rem;
        text-align: left;
    }

    .info-box h4 {
        margin: 0 0 0.5rem 0;
        color: var(--primary);
    }

    .info-box ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    .info-box li {
        margin: 0.5rem 0;
        color: #0369a1;
    }
</style>
@endsection

@section('content')
<div class="error-container">
    <div class="error-card">
        <div class="error-icon">🔒</div>
        <div class="error-code">403</div>
        <h1 class="error-title">Access Denied</h1>
        <p class="error-message">
            {{ $exception->getMessage() ?: 'You do not have permission to access this page.' }}
        </p>

        <div class="error-actions">
            <a href="{{ route('home') }}" class="btn-primary">Go to Home</a>
            <a href="{{ route('login') }}" class="btn-secondary">Login</a>
        </div>

        <div class="info-box">
            <h4>Why am I seeing this?</h4>
            <ul>
                <li>You may not be logged in</li>
                <li>You may not have admin privileges</li>
                <li>The page you're trying to access is restricted</li>
                <li>Your session may have expired</li>
            </ul>
        </div>
    </div>
</div>
@endsection
