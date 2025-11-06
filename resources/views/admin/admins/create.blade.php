@extends('layouts.admin')

@section('title', 'Add New Admin - ORION AI')

@section('styles')
<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
    }

    .form-container h1 {
        color: var(--primary);
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--dark);
        font-weight: 600;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-group small {
        display: block;
        margin-top: 0.25rem;
        color: #64748b;
        font-size: 0.875rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .form-actions button,
    .form-actions a {
        flex: 1;
        padding: 0.875rem;
        border-radius: 8px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-cancel {
        background: #e2e8f0;
        color: var(--dark);
    }

    .btn-cancel:hover {
        background: #cbd5e1;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .preview-image {
        max-width: 150px;
        max-height: 150px;
        border-radius: 8px;
        margin-top: 0.5rem;
        display: none;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="form-container">
        <h1>Add New Admin</h1>

        <form method="POST" action="{{ route('admin.admins.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                <small>A welcome email with login credentials will be sent to this address</small>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                @error('phone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required>
                <small>Minimum 8 characters</small>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password *</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                @error('password_confirmation')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="profile_picture">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" onchange="previewImage(event)">
                <small>Max size: 2MB (JPG, PNG, GIF)</small>
                <img id="preview" class="preview-image" alt="Preview">
                @error('profile_picture')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.admins.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Create Admin</button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
