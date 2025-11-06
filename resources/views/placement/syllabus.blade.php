@extends('layouts.app')

@section('title', 'Placement Syllabus - ORION AI')

@section('styles')
<style>
    .syllabus-hero {
        background: linear-gradient(135deg, rgba(30,58,138,0.95) 0%, rgba(59,130,246,0.95) 100%), 
                    url('https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=1600&h=600&fit=crop') center/cover;
        color: white;
        padding: 5rem 0;
        margin-bottom: 3rem;
        border-radius: 0 0 50px 50px;
        position: relative;
        overflow: hidden;
    }

    .syllabus-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(30,58,138,0.8) 0%, rgba(59,130,246,0.8) 100%);
        z-index: 1;
    }

    .syllabus-hero .container {
        position: relative;
        z-index: 2;
    }

    .syllabus-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-align: center;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .syllabus-hero p {
        font-size: 1.125rem;
        text-align: center;
        opacity: 0.95;
        max-width: 700px;
        margin: 0 auto;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }

    .syllabus-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin: -3rem auto 3rem;
        max-width: 900px;
        padding: 0 1rem;
    }

    .stat-box {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        text-align: center;
        transition: transform 0.3s;
    }

    .stat-box:hover {
        transform: translateY(-5px);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .modules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .module-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
    }

    .module-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
    }

    .module-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 2rem 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .module-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(59,130,246,0.1) 0%, transparent 70%);
    }

    .module-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .hero-image-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin: 3rem 0;
        align-items: center;
    }

    .hero-image {
        width: 100%;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    }

    .hero-content h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
    }

    .hero-content p {
        color: #64748b;
        line-height: 1.8;
        margin-bottom: 1rem;
    }

    .hero-content ul {
        list-style: none;
        padding: 0;
    }

    .hero-content li {
        padding: 0.5rem 0;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .hero-content li::before {
        content: '✓';
        color: #10b981;
        font-weight: 700;
    }

    .module-number {
        display: inline-block;
        background: #1e3a8a;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1.125rem;
    }

    .module-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        position: relative;
    }

    .module-duration {
        color: #64748b;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        font-weight: 500;
    }

    .module-content {
        padding: 1.5rem;
    }

    .topic-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .topic-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .topic-item:last-child {
        border-bottom: none;
    }

    .topic-icon {
        color: #10b981;
        font-weight: 700;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .topic-text {
        color: #475569;
        font-size: 0.9375rem;
        line-height: 1.5;
    }

    .cta-section {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        padding: 3rem 2rem;
        border-radius: 20px;
        text-align: center;
        color: white;
        margin-top: 3rem;
        box-shadow: 0 10px 40px rgba(30,58,138,0.3);
    }

    .cta-section h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .cta-section p {
        font-size: 1.125rem;
        opacity: 0.9;
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-enroll {
        background: white;
        color: #1e3a8a;
        padding: 1rem 3rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.125rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .btn-enroll:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        background: #f8fafc;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin: 3rem 0;
    }

    .feature-box {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        border: 2px solid #e2e8f0;
    }

    .feature-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: #3b82f6;
    }

    .feature-title {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .feature-desc {
        color: #64748b;
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .syllabus-hero {
            padding: 3rem 0;
        }

        .syllabus-hero h1 {
            font-size: 2rem;
        }

        .modules-grid {
            grid-template-columns: 1fr;
        }

        .syllabus-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .hero-image-section {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="syllabus-hero">
    <div class="container">
        <h1>Placement Preparation Syllabus</h1>
        <p>Comprehensive training program designed to help you crack top tech company interviews</p>
    </div>
</div>

<div class="container">
    <div class="syllabus-stats">
        <div class="stat-box">
            <div class="stat-number">4</div>
            <div class="stat-label">Core Modules</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">12</div>
            <div class="stat-label">Weeks Duration</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">50+</div>
            <div class="stat-label">Practice Problems</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">100%</div>
            <div class="stat-label">Job Assistance</div>
        </div>
    </div>

    <div class="hero-image-section">
        <div class="hero-content">
            <h2>Why Choose Our Program?</h2>
            <p>Our comprehensive placement preparation program is designed by industry experts with years of experience in technical recruiting and software engineering.</p>
            <ul>
                <li>Structured learning path</li>
                <li>Real-world problem solving</li>
                <li>Industry-standard practices</li>
                <li>Personalized feedback</li>
                <li>Career guidance</li>
            </ul>
        </div>
        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=600&fit=crop" alt="Team collaboration" class="hero-image">
    </div>

    <div class="features-grid">
        <div class="feature-box">
            <div class="feature-icon">&#9733;</div>
            <div class="feature-title">Expert Mentorship</div>
            <div class="feature-desc">Learn from industry professionals</div>
        </div>
        <div class="feature-box">
            <div class="feature-icon">&#128187;</div>
            <div class="feature-title">Hands-on Practice</div>
            <div class="feature-desc">Real coding challenges</div>
        </div>
        <div class="feature-box">
            <div class="feature-icon">&#128188;</div>
            <div class="feature-title">Mock Interviews</div>
            <div class="feature-desc">Simulate real interview scenarios</div>
        </div>
        <div class="feature-box">
            <div class="feature-icon">&#128200;</div>
            <div class="feature-title">Progress Tracking</div>
            <div class="feature-desc">Monitor your improvement</div>
        </div>
    </div>

    <div class="modules-grid">
        <div class="module-card">
            <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&h=200&fit=crop" alt="Data Structures" class="module-image">
            <div class="module-header">
                <div class="module-number">1</div>
                <h3 class="module-title">Data Structures & Algorithms</h3>
                <div class="module-duration">Duration: 4 Weeks</div>
            </div>
            <div class="module-content">
                <ul class="topic-list">
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Arrays, Strings, and Linked Lists</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Stacks, Queues, and Hash Tables</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Trees and Graphs</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Sorting and Searching Algorithms</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Dynamic Programming</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="module-card">
            <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600&h=200&fit=crop" alt="System Design" class="module-image">
            <div class="module-header">
                <div class="module-number">2</div>
                <h3 class="module-title">System Design</h3>
                <div class="module-duration">Duration: 3 Weeks</div>
            </div>
            <div class="module-content">
                <ul class="topic-list">
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Scalability Fundamentals</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Database Design</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Caching Strategies</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Load Balancing</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Microservices Architecture</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="module-card">
            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&h=200&fit=crop" alt="Interview Preparation" class="module-image">
            <div class="module-header">
                <div class="module-number">3</div>
                <h3 class="module-title">Interview Preparation</h3>
                <div class="module-duration">Duration: 3 Weeks</div>
            </div>
            <div class="module-content">
                <ul class="topic-list">
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Resume Building</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Behavioral Interview Questions</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Technical Interview Practice</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Mock Interviews</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Salary Negotiation</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="module-card">
            <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=600&h=200&fit=crop" alt="Aptitude & Reasoning" class="module-image">
            <div class="module-header">
                <div class="module-number">4</div>
                <h3 class="module-title">Aptitude & Reasoning</h3>
                <div class="module-duration">Duration: 2 Weeks</div>
            </div>
            <div class="module-content">
                <ul class="topic-list">
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Quantitative Aptitude</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Logical Reasoning</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Verbal Ability</span>
                    </li>
                    <li class="topic-item">
                        <span class="topic-icon">&#10003;</span>
                        <span class="topic-text">Puzzles and Problem Solving</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="cta-section">
        <h2>Ready to Start Your Journey?</h2>
        <p>Join thousands of students who have successfully landed their dream jobs with our placement preparation program</p>
        <a href="{{ route('placement.index') }}" class="btn-enroll">Enroll Now</a>
    </div>
</div>
@endsection
