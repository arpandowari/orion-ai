@extends('layouts.app')

@section('title', $course->name . ' - Syllabus')

@section('styles')
<style>
    .syllabus-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .syllabus-header h1 {
        margin-bottom: 0.5rem;
    }

    .syllabus-content {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        white-space: pre-line;
        line-height: 1.8;
    }

    .enroll-section {
        text-align: center;
        margin-top: 2rem;
        padding: 2rem;
        background: var(--light);
        border-radius: 12px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="syllabus-header">
        <h1>{{ $course->name }}</h1>
        <p>{{ $course->description }}</p>
    </div>

    <div class="syllabus-content">
        <h2 style="color: var(--primary); margin-bottom: 1rem;">Course Syllabus</h2>
        @if($course->syllabus)
            <p>{{ $course->syllabus }}</p>
        @else
            <p>Comprehensive curriculum covering all essential topics in {{ $course->name }}. Contact us for detailed syllabus.</p>
        @endif
    </div>

    <div class="enroll-section">
        <h3 style="color: var(--primary); margin-bottom: 1rem;">Ready to Start Learning?</h3>
        <a href="{{ route('registration.create', $course->id) }}" class="btn btn-primary">Enroll Now</a>
    </div>
</div>
@endsection
