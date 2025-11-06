@extends('layouts.admin')

@section('title', 'Edit Course - Admin')

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

    .help-text {
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 0.25rem;
    }

    .current-thumbnail {
        margin-top: 0.5rem;
        max-width: 200px;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<div class="form-container">
        <div class="form-header">
            <h1>Edit Course</h1>
            <p>Update course information</p>
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

        <form method="POST" action="{{ route('admin.courses.update', $course->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Course Name *</label>
                <input type="text" id="name" name="name" required value="{{ old('name', $course->name) }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description', $course->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="syllabus">Syllabus</label>
                <textarea id="syllabus" name="syllabus">{{ old('syllabus', $course->syllabus) }}</textarea>
            </div>

            <div class="form-group">
                <label for="thumbnail">Course Thumbnail</label>
                @if($course->thumbnail)
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Current thumbnail" class="current-thumbnail">
                @endif
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
                <div class="help-text">Leave empty to keep current thumbnail</div>
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="is_active" name="is_active" {{ $course->is_active ? 'checked' : '' }}>
                    <label for="is_active" style="margin: 0;">Active (visible on website)</label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Update Course</button>
            </div>
        </form>
    </div>
@endsection
