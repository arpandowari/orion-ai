@extends('layouts.app')

@section('title', 'Student Dashboard - ORION AI')

@section('styles')
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 2.5rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .welcome-section h1 {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .welcome-section p {
        opacity: 0.95;
    }

    .logout-btn {
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        border: 2px solid rgba(255,255,255,0.3);
    }

    .logout-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-2px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        text-align: center;
    }

    .stat-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #64748b;
        font-weight: 600;
    }

    .progress-section {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .progress-section h2 {
        color: var(--primary);
        margin-bottom: 1.5rem;
    }

    .progress-bar-container {
        background: #e2e8f0;
        height: 30px;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        transition: width 0.5s ease;
    }

    .course-complete-badge {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 2rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .action-btn {
        flex: 1;
        min-width: 200px;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s;
    }

    .btn-primary-action {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
    }

    .btn-primary-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn-secondary-action {
        background: #f1f5f9;
        color: var(--dark);
    }

    .btn-secondary-action:hover {
        background: #e2e8f0;
    }

    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .welcome-section h1 {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <div class="welcome-section">
            <h1>Welcome back, {{ $student->name }}</h1>
            <p>{{ $student->course->name }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    @if($courseCompleted)
        <div class="course-complete-badge">
            Congratulations! You have successfully completed the course
        </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
            </div>
            <div class="stat-value">{{ $totalVideos }}</div>
            <div class="stat-label">Total Lessons</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <div class="stat-value">{{ $completedCount }}</div>
            <div class="stat-label">Completed</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
            <div class="stat-value">{{ $progressPercentage }}%</div>
            <div class="stat-label">Progress</div>
        </div>
    </div>

    <div class="progress-section">
        <h2>Course Progress</h2>
        <div class="progress-bar-container">
            <div class="progress-bar-fill" style="width: {{ $progressPercentage }}%">
                {{ $progressPercentage }}%
            </div>
        </div>
        <p style="color: #64748b; text-align: center;">
            You've completed {{ $completedCount }} out of {{ $totalVideos }} lessons
        </p>
    </div>

    <div class="action-buttons">
        <a href="{{ route('courses.show', $student->course_id) }}" class="action-btn btn-primary-action">
            Continue Learning
        </a>
        <a href="{{ route('student.profile') }}" class="action-btn btn-secondary-action">
            View Profile
        </a>
    </div>
</div>
@endsection
