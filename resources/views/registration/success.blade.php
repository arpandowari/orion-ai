@extends('layouts.app')

@section('title', 'Registration Success - ORION AI')

@section('styles')
<style>
    .success-container {
        text-align: center;
        padding: 4rem 2rem;
    }

    .success-icon {
        font-size: 5rem;
        color: var(--success);
        margin-bottom: 1rem;
    }

    .success-container h1 {
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .success-container p {
        font-size: 1.2rem;
        color: var(--dark);
        margin-bottom: 2rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="success-container">
        <div class="success-icon">✓</div>
        <h1>Thank You for Registering!</h1>
        <p>Our team will contact you shortly to complete the enrollment process.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
    </div>
</div>
@endsection
