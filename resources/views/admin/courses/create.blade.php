@extends('layouts.admin')

@section('title', 'Add New Course - Admin')

@section('styles')
<style>
    .form-container {
        max-width: 800px;
        margin: 2rem auto;
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .form-header {
        margin-bottom: 2rem;
    }

    .form-header h1 {
        color: var(--primary);
        margin-bottom: 0.5rem;
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
    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
    }

    .form-group textarea {
        min-height: 150px;
        resize: vertical;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--secondary);
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .checkbox-group input[type="checkbox"] {
        width: auto;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .btn-cancel {
        background: #64748b;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
    }

    .btn-submit {
        background: var(--success);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-submit:hover {
        background: #059669;
    }

    .help-text {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('content')
<div class="form-container">
        <div class="form-header">
            <h1>Add New Course</h1>
            <p>Create a new course for students to enroll in</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Course Name *</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="e.g., Advanced JavaScript">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Brief description of the course">{{ old('description') }}</textarea>
                <div class="help-text">This will be shown on the course card</div>
            </div>

            <div class="form-group">
                <label for="syllabus">Syllabus</label>
                <textarea id="syllabus" name="syllabus" placeholder="Module 1: Introduction&#10;Module 2: Advanced Topics&#10;Module 3: Projects">{{ old('syllabus') }}</textarea>
                <div class="help-text">Use line breaks to separate modules</div>
            </div>

            <div class="form-group">
                <label for="thumbnail">Course Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                <div class="help-text">Optional. Max 2MB. JPG, PNG, or GIF</div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="is_active" name="is_active" checked>
                    <label for="is_active" style="margin: 0;">Active (visible on website)</label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Create Course</button>
            </div>
        </form>
    </div>
@endsection
