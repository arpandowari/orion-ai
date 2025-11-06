@extends('layouts.app')

@section('title', 'Placement Series - ORION AI')

@section('styles')
<style>
    .placement-hero {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 3rem 2rem;
        text-align: center;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .placement-hero h1 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }

    .enroll-form {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        max-width: 500px;
        margin: 2rem auto;
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
    }

    .price-display {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 2rem;
        border-radius: 12px;
        text-align: center;
        margin: 1.5rem 0;
        color: white;
        display: none;
        animation: slideDown 0.5s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .price-display p {
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .price-display h3 {
        color: white;
        font-size: 2.5rem;
        margin: 0;
    }

    #enrollForm {
        display: none;
    }

    #enrollButton {
        display: none;
    }

    .step-indicator {
        text-align: center;
        color: #64748b;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .companies-section {
        background: white;
        padding: 3rem 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .companies-section h2 {
        text-align: center;
        color: var(--primary);
        margin-bottom: 2rem;
    }

    .companies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 2rem;
        max-width: 900px;
        margin: 0 auto;
    }

    .company-item {
        background: var(--light);
        padding: 1.5rem;
        border-radius: 8px;
        text-align: center;
        font-weight: 600;
        color: var(--dark);
        transition: all 0.3s;
        border: 2px solid transparent;
    }

    .company-item:hover {
        border-color: var(--secondary);
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .placement-features {
        background: var(--light);
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .feature-item {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        text-align: center;
    }

    .feature-item h4 {
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .feature-item p {
        color: #64748b;
        font-size: 0.9rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="placement-hero">
        <h1>Complete Placement Preparation</h1>
        <p>Get industry-ready with our comprehensive placement training program</p>
        <div class="action-buttons">
            <a href="{{ route('placement.syllabus') }}" class="btn btn-outline" style="background: white; color: var(--primary);">Explore</a>
            <button onclick="showEnrollForm()" class="btn btn-primary" style="background: white; color: var(--primary);">Enroll</button>
        </div>
    </div>

    <div class="companies-section">
        <h2>Our Placement Partner Companies</h2>
        <p style="text-align: center; color: #64748b; margin-bottom: 2rem;">Students from our placement program have been placed in top companies</p>
        <div class="companies-grid">
            <div class="company-item">Google</div>
            <div class="company-item">Microsoft</div>
            <div class="company-item">Amazon</div>
            <div class="company-item">Meta</div>
            <div class="company-item">Apple</div>
            <div class="company-item">Netflix</div>
            <div class="company-item">Adobe</div>
            <div class="company-item">IBM</div>
            <div class="company-item">Oracle</div>
            <div class="company-item">Salesforce</div>
            <div class="company-item">Intel</div>
            <div class="company-item">Cisco</div>
        </div>
    </div>

    <div class="placement-features">
        <h2 style="text-align: center; color: var(--primary); margin-bottom: 1rem;">What You'll Get</h2>
        <div class="features-grid">
            <div class="feature-item">
                <h4>Complete Curriculum</h4>
                <p>DSA, System Design, Interview Prep, and more</p>
            </div>
            <div class="feature-item">
                <h4>Mock Interviews</h4>
                <p>Practice with industry experts</p>
            </div>
            <div class="feature-item">
                <h4>Resume Building</h4>
                <p>Professional resume review and optimization</p>
            </div>
            <div class="feature-item">
                <h4>Job Referrals</h4>
                <p>Direct referrals to partner companies</p>
            </div>
            <div class="feature-item">
                <h4>Lifetime Access</h4>
                <p>Access all materials anytime, anywhere</p>
            </div>
            <div class="feature-item">
                <h4>Mentorship</h4>
                <p>1-on-1 guidance from industry mentors</p>
            </div>
        </div>
    </div>

    <div id="enrollForm" class="enroll-form">
        <div class="step-indicator">Step 1 of 2: Enter Your Details</div>
        <h2 style="text-align: center; color: var(--primary); margin-bottom: 1.5rem;">Enrollment Details</h2>
        
        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('placement.enroll') }}" id="enrollmentForm">
            @csrf
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}" onchange="checkFormComplete()">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number *</label>
                <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}" onchange="checkFormComplete()">
            </div>

            <button type="button" id="showPriceBtn" class="btn btn-outline" style="width: 100%; margin-bottom: 1rem;" onclick="showPrice()">Continue to See Fee</button>

            <div id="priceSection" class="price-display">
                <p>💰 Program Fee</p>
                <h3>₹25,000</h3>
                <p style="font-size: 0.9rem; margin-top: 1rem;">One-time payment for complete placement preparation</p>
            </div>

            <button type="submit" id="enrollButton" class="btn btn-primary" style="width: 100%;">Confirm Enrollment</button>
        </form>
    </div>
</div>

<script>
    function showEnrollForm() {
        document.getElementById('enrollForm').style.display = 'block';
        document.getElementById('enrollForm').scrollIntoView({ behavior: 'smooth' });
    }

    function checkFormComplete() {
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const showPriceBtn = document.getElementById('showPriceBtn');
        
        if (email && phone) {
            showPriceBtn.disabled = false;
            showPriceBtn.style.opacity = '1';
        } else {
            showPriceBtn.disabled = true;
            showPriceBtn.style.opacity = '0.5';
        }
    }

    function showPrice() {
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        
        if (!email || !phone) {
            alert('Please enter both email and phone number first');
            return;
        }

        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Please enter a valid email address');
            return;
        }

        // Validate phone (basic check)
        if (phone.length < 10) {
            alert('Please enter a valid phone number');
            return;
        }

        // Show price and enroll button
        document.getElementById('priceSection').style.display = 'block';
        document.getElementById('enrollButton').style.display = 'block';
        document.getElementById('showPriceBtn').style.display = 'none';
        document.querySelector('.step-indicator').textContent = 'Step 2 of 2: Review and Confirm';
        
        // Scroll to price section
        document.getElementById('priceSection').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Initialize button state
    document.addEventListener('DOMContentLoaded', function() {
        checkFormComplete();
        
        @if(old('email') || old('phone'))
            showEnrollForm();
        @endif
    });
</script>
@endsection


