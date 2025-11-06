@extends('layouts.app')

@section('title', 'Register for ' . $course->name)

@section('styles')
<style>
    .registration-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        text-align: center;
    }

    .registration-form {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid var(--light);
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .form-section h3 {
        color: var(--primary);
        margin-bottom: 1.5rem;
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

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--secondary);
    }

    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }

    .internship-box {
        background: var(--light);
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .internship-box h4 {
        color: var(--secondary);
        margin-bottom: 1rem;
    }

    .required {
        color: #ef4444;
    }

    .file-info {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="registration-header">
        <h1>Register for {{ $course->name }}</h1>
        <p>Fill in your details to enroll in this course</p>
    </div>

    <div class="registration-form">
        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('registration.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">

            <div class="form-section">
                <h3>Personal Information</h3>
                
                <div class="form-group">
                    <label for="name">Full Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}">
                    <div class="file-info">This will be your login email</div>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required minlength="8">
                    <div class="file-info">Minimum 8 characters - You'll use this to login</div>
                    @error('password')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8">
                    @error('password_confirmation')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cgpa">CGPA</label>
                    <input type="number" id="cgpa" name="cgpa" step="0.01" min="0" max="10" value="{{ old('cgpa') }}">
                </div>

                <div class="form-group">
                    <label for="education_details">Education Details</label>
                    <textarea id="education_details" name="education_details">{{ old('education_details') }}</textarea>
                </div>
            </div>

            <div class="form-section">
                <h3>Internship Experience</h3>
                
                @for($i = 1; $i <= 3; $i++)
                <div class="internship-box">
                    <h4>Internship {{ $i }}</h4>
                    
                    <div class="form-group">
                        <label for="internship_company_{{ $i }}">Company Name</label>
                        <input type="text" id="internship_company_{{ $i }}" name="internship_company_{{ $i }}" value="{{ old('internship_company_' . $i) }}">
                    </div>

                    <div class="form-group">
                        <label for="internship_certificate_{{ $i }}">Certificate</label>
                        <input type="text" id="internship_certificate_{{ $i }}" name="internship_certificate_{{ $i }}" value="{{ old('internship_certificate_' . $i) }}">
                    </div>

                    <div class="form-group">
                        <label for="internship_stipend_{{ $i }}">Stipend Received</label>
                        <input type="text" id="internship_stipend_{{ $i }}" name="internship_stipend_{{ $i }}" value="{{ old('internship_stipend_' . $i) }}">
                    </div>
                </div>
                @endfor
            </div>

            <div class="form-section">
                <h3>Additional Information</h3>
                
                <div class="form-group">
                    <label for="extracurricular_activities">Extra-curricular Activities</label>
                    <textarea id="extracurricular_activities" name="extracurricular_activities">{{ old('extracurricular_activities') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="goal">Your Goal</label>
                    <textarea id="goal" name="goal">{{ old('goal') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="suitable_role">Role Suitable for You</label>
                    <input type="text" id="suitable_role" name="suitable_role" value="{{ old('suitable_role') }}">
                </div>

                <div class="form-group">
                    <label for="expected_ctc">Expected CTC (in LPA)</label>
                    <input type="number" id="expected_ctc" name="expected_ctc" step="0.01" value="{{ old('expected_ctc') }}">
                </div>
            </div>

            <div class="form-section">
                <h3>Required Documents</h3>
                
                <div class="form-group">
                    <label for="resume">Resume <span class="required">*</span></label>
                    <input type="file" id="resume" name="resume" accept=".pdf,.docx" required>
                    <p class="file-info">Accepted formats: PDF, DOCX (Max size: 10MB)</p>
                </div>

                <div class="form-group">
                    <label for="marksheet">Marksheet <span class="required">*</span></label>
                    <input type="file" id="marksheet" name="marksheet" accept=".pdf,.docx" required>
                    <p class="file-info">Accepted formats: PDF, DOCX (Max size: 10MB)</p>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.1rem;">Submit Registration</button>
        </form>
    </div>
</div>
@endsection
