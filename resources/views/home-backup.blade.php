@extends('layouts.app')

@section('title', 'ORION AI - Home')

@section('styles')
<style>
    .hero {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 4rem 2rem;
        text-align: center;
        border-radius: 12px;
        margin-bottom: 3rem;
    }

    .hero h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
    }

    .companies {
        background: white;
        padding: 3rem 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 3rem;
    }

    .companies h2 {
        text-align: center;
        color: var(--primary);
        margin-bottom: 2rem;
    }

    .company-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 2rem;
        text-align: center;
    }

    .company-item {
        padding: 1.5rem;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
    }

    .company-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .company-item a {
        display: block;
        width: 100%;
        height: 100%;
    }

    .partner-logo {
        max-width: 100%;
        max-height: 80px;
        object-fit: contain;
        filter: grayscale(100%);
        transition: filter 0.3s;
    }

    .company-item:hover .partner-logo {
        filter: grayscale(0%);
    }

    .courses-preview {
        margin-top: 3rem;
    }

    .courses-preview h2 {
        text-align: center;
        color: var(--primary);
        margin-bottom: 2rem;
    }

    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .course-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }

    .course-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .course-content {
        padding: 1.5rem;
    }

    .course-content h3 {
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .course-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .register-section {
        background: white;
        padding: 3rem 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin: 3rem 0;
    }

    .register-section h2 {
        text-align: center;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .register-section p {
        text-align: center;
        color: #64748b;
        margin-bottom: 2rem;
    }

    .register-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        max-width: 900px;
        margin: 0 auto;
    }

    .register-card {
        background: white;
        border-radius: 16px;
        text-align: center;
        border: 1px solid #e2e8f0;
        transition: all 0.3s;
        overflow: hidden;
    }

    .register-card:hover {
        border-color: var(--secondary);
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15);
    }

    .register-card-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    .register-card-content {
        padding: 2rem;
    }

    .register-card h3 {
        color: var(--primary);
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .register-card p {
        color: #64748b;
        margin-bottom: 1.5rem;
        text-align: center;
        line-height: 1.6;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="hero">
        <h1>Welcome to ORION AI</h1>
        <p>Transform Your Career with Industry-Leading Courses</p>
        <a href="#register" class="btn btn-primary" style="background: white; color: var(--primary); font-size: 1.1rem;">Join Now!!</a>
    </div>

    @if($partners->count() > 0)
    <div class="companies">
        <h2>Our Partner Companies</h2>
        <div class="company-grid">
            @foreach($partners as $partner)
                <div class="company-item">
                    @if($partner->website_url)
                        <a href="{{ $partner->website_url }}" target="_blank" rel="noopener">
                            <img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}" class="partner-logo">
                        </a>
                    @else
                        <img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}" class="partner-logo">
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div id="register" class="register-section">
        <h2>Start Your Learning Journey</h2>
        <p>Choose your path to success</p>
        
        <div class="register-options">
            <div class="register-card">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&h=400&fit=crop" alt="Browse Courses" class="register-card-image">
                <div class="register-card-content">
                    <h3>Browse Courses</h3>
                    <p>Explore our wide range of professional courses in Data Science, Web Development, and more</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary">View All Courses</a>
                </div>
            </div>

            <div class="register-card">
                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&h=400&fit=crop" alt="Placement Series" class="register-card-image">
                <div class="register-card-content">
                    <h3>Placement Series</h3>
                    <p>Complete placement preparation program to land your dream job</p>
                    <a href="{{ route('placement.index') }}" class="btn btn-primary">Enroll in Placement</a>
                </div>
            </div>

            <div class="register-card">
                <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=600&h=400&fit=crop" alt="Quick Register" class="register-card-image">
                <div class="register-card-content">
                    <h3>Quick Register</h3>
                    <p>Already know which course? Register directly and start learning</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-primary">Register Now</a>
                </div>
            </div>
        </div>
    </div>

    <div class="courses-preview">
        <h2>Featured Courses</h2>
        <div class="course-grid">
            @forelse($courses as $course)
                <div class="course-card">
                    <img src="{{ $course->thumbnail ?? 'https://via.placeholder.com/400x200?text=' . urlencode($course->name) }}" alt="{{ $course->name }}">
                    <div class="course-content">
                        <h3>{{ $course->name }}</h3>
                        <p>{{ Str::limit($course->description, 100) }}</p>
                        <div class="course-actions">
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline">Watch Free</a>
                            <a href="{{ route('registration.create', $course->id) }}" class="btn btn-primary">Enroll Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <p style="text-align: center; grid-column: 1/-1;">No courses available at the moment.</p>
            @endforelse
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Smooth scroll to register section
    document.addEventListener('DOMContentLoaded', function() {
        const joinButton = document.querySelector('a[href="#register"]');
        if (joinButton) {
            joinButton.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('register').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        }
    });
</script>
@endsection
@endsection
