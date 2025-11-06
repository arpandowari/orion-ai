@extends('layouts.app')

@section('title', 'Courses - ORION AI')

@section('styles')
<style>
    body {
        background: var(--light);
    }

    .courses-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }

    /* Hero Header */
    .courses-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        background: var(--gradient-primary);
        color: #ffffff;
        padding: 4rem 2rem;
        border-radius: 20px;
        text-align: center;
        margin-bottom: 4rem;
        position: relative;
        overflow: hidden;
    }
    
    .courses-hero * {
        color: #ffffff !important;
    }

    .courses-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    

  
        background: linear-gradient(135deg, #006eff 70%, #00aeff 100%);
        color: #fff;
        padding: 100px 0;
        border-radius: 0 0 30px 30px; /* optional: soft curve at bottom */
        text-align: center;
        


        opacity: 0.8;
    



    
    }
    .courses-hero-content {
        position: relative;
        z-index: 1;
    }

    .courses-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
        color: #ffffff !important;
    }

    .courses-hero p {
        font-size: 1.25rem;
        opacity: 0.95;
        max-width: 700px;
        margin: 0 auto;
        color: #ffffff !important;
    }

    .courses-hero .subtitle {
        font-size: 1rem;
        opacity: 0.85;
        margin-top: 0.5rem;
        color: #ffffff !important;
    }

    /* Stats Bar */
    .courses-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        display: block;
        margin-bottom: 0.25rem;
        color: #ffffff !important;
    }

    .stat-label {
        font-size: 0.95rem;
        opacity: 0.9;
        color: #ffffff !important;
    }

    /* Section Header */
    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-header h2 {
        font-size: 2.25rem;
        color: #0f172a;
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .section-header p {
        font-size: 1.1rem;
        color: #64748b;
        color: var(--gray);
        max-width: 600px;
        margin: 0 auto;
    }

    /* Course Grid */
    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 2rem;
    }

    .course-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.15);
        border-color: #2563eb;
    }
    
    /* Ensure all text in course cards is visible */
    .course-card * {
        color: inherit;
    }
    
    .course-card .course-content {
        background: #ffffff;
    }

    .course-thumbnail {
        width: 100%;
        height: 220px;
        background: var(--gradient-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #000000 !important;
        font-size: 1.75rem;
        font-weight: 700;
        position: relative;
        overflow: hidden;
        padding: 2rem;
        text-align: center;
        line-height: 1.3;
    }
    
    .course-thumbnail * {
        color: #000000 !important;
    }

    .course-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
    }

    .course-placeholder {
        position: relative;
        z-index: 1;
        opacity: 0.9;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }
    
    .course-placeholder-title {
        color: #000000 !important;
        font-size: 1.5rem;
        font-weight: 700;
        text-shadow: 0 2px 8px rgba(255,255,255,0.3);
    }
    
    .course-thumbnail .course-placeholder-title {
        color: #000000 !important;
    }
    
    .course-thumbnail div {
        color: #000000 !important;
    }

    .course-placeholder svg {
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        stroke: #000000 !important;
    }

    .course-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.95);
        color: #2563eb !important;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .course-content {
        padding: 2rem;
        background: #ffffff;
        color: #0f172a;
    }

    .course-meta {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: #64748b !important;
    }

    .course-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b !important;
    }
    
    .course-meta-item span {
        color: #64748b !important;
    }
    
    .course-meta-item svg {
        color: #64748b !important;
        stroke: #64748b !important;
    }

    .course-card .course-content h3 {
        color: #0f172a !important;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .course-card .course-content p {
        color: #334155 !important;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .course-card h3 {
        color: #0f172a !important;
    }
    
    .course-card p {
        color: #334155 !important;
    }

    .course-actions {
        display: flex;
        gap: 1rem;
    }

    .course-actions .btn {
        flex: 1;
        text-align: center;
        padding: 0.875rem 1.5rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-outline {
        background: #f1f5f9;
        color: #0f172a !important;
        border: 2px solid #cbd5e1;
    }

    .btn-outline:hover {
        background: #cbd5e1;
        border-color: #2563eb;
        color: #2563eb !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
        color: #ffffff !important;
        border: none;
    }

    .btn-primary:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
    }

    /* Empty State */
    .empty-state {
        grid-column: 1/-1;
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
    }

    .empty-state svg {
        width: 120px;
        height: 120px;
        margin-bottom: 2rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        color: #0f172a !important;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #64748b !important;
        font-size: 1.1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .courses-hero h1 {
            font-size: 2rem;
        }

        .courses-hero p {
            font-size: 1.1rem;
        }

        .course-grid {
            grid-template-columns: 1fr;
        }

        .courses-stats {
            gap: 2rem;
        }

        .stat-number {
            font-size: 2rem;
        }
    }

    @media (max-width: 480px) {
        .courses-container {
            padding: 2rem 1rem;
        }

        .courses-hero {
            padding: 3rem 1.5rem;
        }

        .course-content {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="courses-container">
    <!-- Hero Section -->
    <div class="courses-hero">
        <div class="courses-hero-content">
            <h1 style="color: #1d4ed8;">Professional Training Programs</h1>
            <p>Industry-leading courses designed to accelerate your career growth</p>
            <p class="subtitle">Learn from experts • Hands-on projects • Career support</p>
            
            <div class="courses-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $courses->count() }}+</span>
                    <span class="stat-label">Courses</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">5000+</span>
                    <span class="stat-label">Students</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">95%</span>
                    <span class="stat-label">Success Rate</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Section -->
    <div class="section-header">
        <h2>Available Courses</h2>
        <p>Choose from our comprehensive selection of industry-relevant training programs</p>
    </div>

    <div class="course-grid">
        @forelse($courses as $course)
            <div class="course-card">
                <div class="course-thumbnail">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->name }}">
                    @else
                        <div class="course-placeholder">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                            </svg>
                            <div class="course-placeholder-title">{{ $course->name }}</div>
                        </div>
                    @endif
                    <span class="course-badge">Professional</span>
                </div>
                
                <div class="course-content">
                    <div class="course-meta">
                        <div class="course-meta-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>Self-paced</span>
                        </div>
                        <div class="course-meta-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>Expert-led</span>
                        </div>
                    </div>

                    <h3>{{ $course->name }}</h3>
                    <p>{{ Str::limit($course->description, 120) }}</p>
                    
                    <div class="course-actions">
                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline">Preview Course</a>
                        <a href="{{ route('registration.create', $course->id) }}" class="btn btn-primary">Enroll Now</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
                <h3>No Courses Available</h3>
                <p>We're preparing exciting new courses. Check back soon!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
