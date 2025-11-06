@extends('layouts.app')

@section('title', 'Page Not Found - ORION AI')

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

    .suggestions {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 8px;
        margin-top: 2rem;
        text-align: left;
    }

    .suggestions h4 {
        margin: 0 0 1rem 0;
        color: var(--primary);
    }

    .suggestions a {
        display: block;
        padding: 0.5rem 0;
        color: var(--secondary);
        text-decoration: none;
        font-weight: 500;
    }

    .suggestions a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="error-container">
    <div class="error-card">
        <div class="error-icon">🔍</div>
        <div class="error-code">404</div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-message">
            Oops! The page you're looking for doesn't exist or has been moved.
        </p>

        <div class="error-actions">
            <a href="{{ route('home') }}" class="btn-primary">Go to Home</a>
            <a href="javascript:history.back()" class="btn-secondary">Go Back</a>
        </div>

        <div class="suggestions">
            <h4>Popular Pages:</h4>
            <a href="{{ route('home') }}">🏠 Home</a>
            <a href="{{ route('courses.index') }}">📚 Browse Courses</a>
            <a href="{{ route('placement.index') }}">💼 Placement Series</a>
            <a href="{{ route('login') }}">🔐 Login</a>
        </div>
    </div>
</div>
@endsection
