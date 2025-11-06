@extends('layouts.app')

@section('title', 'ORION AI - Learn & Grow')

@section('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f8fafc;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 5rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,106.7C1248,96,1344,96,1392,96L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
        opacity: 0.3;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .hero-content p {
        font-size: 1.25rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }

    .hero-cta {
        display: inline-block;
        padding: 1.25rem 3rem;
        background: white;
        color: #1e3a8a;
        font-size: 1.25rem;
        font-weight: 700;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .hero-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    }

    /* Main Container */
    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }

    /* Section Styles */
    .section {
        margin-bottom: 4rem;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-header h2 {
        font-size: 2.5rem;
        color: #1e3a8a;
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .section-header p {
        font-size: 1.1rem;
        color: #64748b;
    }

    /* Placement Series Section */
    .placement-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .placement-card h3 {
        font-size: 2rem;
        color: #1e3a8a;
        margin-bottom: 1rem;
    }

    .placement-card p {
        font-size: 1.1rem;
        color: #64748b;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .placement-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-explore {
        padding: 1rem 2.5rem;
        background: transparent;
        color: #3b82f6;
        border: 2px solid #3b82f6;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-explore:hover {
        background: #3b82f6;
        color: white;
        transform: translateY(-2px);
    }

    .btn-enroll {
        padding: 1rem 2.5rem;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-enroll:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
    }

    .placement-info {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
        padding: 1.5rem;
        border-radius: 10px;
        margin-top: 2rem;
        text-align: left;
    }

    .placement-info h4 {
        color: #1e40af;
        margin-bottom: 0.75rem;
        font-size: 1.1rem;
    }

    .placement-info p {
        color: #1e40af;
        margin: 0;
        font-size: 0.95rem;
    }

    /* Courses Grid */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
    }

    .course-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s;
        cursor: pointer;
    }

    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }

    .course-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: var(--gradient-secondary);
    }

    .course-content {
        padding: 2rem;
    }

    .course-content h3 {
        font-size: 1.5rem;
        color: #1e3a8a;
        margin-bottom: 0.75rem;
        font-weight: 700;
    }

    .course-content p {
        color: #64748b;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .course-actions {
        display: flex;
        gap: 1rem;
    }

    .course-actions a {
        flex: 1;
        padding: 0.875rem;
        text-align: center;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-preview {
        background: #f1f5f9;
        color: #1e3a8a;
    }

    .btn-preview:hover {
        background: #e2e8f0;
    }

    .btn-enroll-course {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        color: white;
    }

    .btn-enroll-course:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
    }

    /* Companies Section */
    .companies-section {
        background: white;
        padding: 3rem 2rem;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .companies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .company-item {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background: #f8fafc;
        border-radius: 12px;
        transition: all 0.3s;
        border: 2px solid transparent;
    }

    .company-item:hover {
        border-color: #3b82f6;
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .company-logo {
        max-width: 100%;
        max-height: 80px;
        object-fit: contain;
        filter: grayscale(100%);
        transition: filter 0.3s;
    }

    .company-item:hover .company-logo {
        filter: grayscale(0%);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.5rem;
        }

        .hero-content p {
            font-size: 1.1rem;
        }

        .section-header h2 {
            font-size: 2rem;
        }

        .courses-grid {
            grid-template-columns: 1fr;
        }

        .placement-buttons {
            flex-direction: column;
        }

        .placement-buttons a {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .hero-section {
            padding: 3rem 1rem;
        }

        .hero-content h1 {
            font-size: 2rem;
        }

        .main-container {
            padding: 2rem 1rem;
        }

        .placement-card {
            padding: 2rem 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-content">
        <h1>Transform Your Career with ORION AI</h1>
        <p>Industry-leading courses, expert mentorship, and guaranteed placement support</p>
        <a href="#courses" class="hero-cta">Get Started</a>
    </div>
</div>

<!-- Main Container -->
<div class="main-container">
    
    <!-- Placement Series Section -->
    <section class="section">
        <div class="section-header">
            <h2>Placement Preparation Program</h2>
            <p>Comprehensive training for career success</p>
        </div>
        
        <div class="placement-card">
            <h3>Complete Placement Preparation</h3>
            <p>Get job-ready with our comprehensive placement series covering DSA, System Design, Interview Prep, and more. Join thousands of successful candidates who landed their dream jobs.</p>
            
            <div class="placement-buttons">
                <a href="{{ route('placement.syllabus') }}" class="btn-explore">View Syllabus</a>
                <a href="{{ route('placement.index') }}" class="btn-enroll">Enroll Now</a>
            </div>

            <div class="placement-info">
                <h4>Program Details</h4>
                <p><strong>Explore:</strong> View detailed syllabus and course structure</p>
                <p><strong>Enroll:</strong> Complete registration form with your details. Program fee: ₹25,000. Start learning immediately after enrollment.</p>
            </div>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="section" id="courses">
        <div class="section-header">
            <h2>Featured Courses</h2>
            <p>Industry-relevant professional training programs</p>
        </div>

        <div class="courses-grid">
            @forelse($courses as $course)
                <div class="course-card">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->name }}" class="course-image">
                    @else
                        <div class="course-image" style="display: flex; align-items: center; justify-content: center; color: black; font-size: 2rem; font-weight: 700;">
                            {{ $course->name }}
                        </div>
                    @endif
                    
                    <div class="course-content">
                        <h3>{{ $course->name }}</h3>
                        <p>{{ Str::limit($course->description, 120) }}</p>
                        
                        <div class="course-actions">
                            <a href="{{ route('courses.show', $course->id) }}" class="btn-preview">Preview Course</a>
                            <a href="{{ route('registration.create', $course->id) }}" class="btn-enroll-course">Enroll Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                    <p style="font-size: 1.2rem; color: #64748b;">No courses available at the moment.</p>
                </div>
            @endforelse
        </div>
    </section>



</div>

<script>
// Smooth scroll
document.addEventListener('DOMContentLoaded', function() {
    const heroBtn = document.querySelector('.hero-cta');
    if (heroBtn) {
        heroBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('courses').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        });
    }
});
</script>
@endsection
