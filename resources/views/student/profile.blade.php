@extends('layouts.app')

@section('title', 'My Profile - ORION AI')

@section('styles')
<style>
    .profile-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
    }

    .profile-header {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--secondary);
    }

    .profile-avatar-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        font-weight: 700;
    }

    .profile-info h1 {
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .profile-info p {
        color: #64748b;
        margin-bottom: 0.25rem;
    }

    .progress-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .complete-badge {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .section-card {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .section-card h2 {
        color: var(--primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .video-list {
        display: grid;
        gap: 1rem;
    }

    .video-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 10px;
        border-left: 4px solid var(--success);
    }

    .video-icon {
        width: 50px;
        height: 50px;
        background: #d1fae5;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .video-details h3 {
        color: var(--dark);
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .video-details p {
        color: #64748b;
        font-size: 0.875rem;
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

    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-group input:focus {
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

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .update-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .update-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .back-btn {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background: #f1f5f9;
        color: var(--dark);
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        margin-bottom: 2rem;
        transition: all 0.3s;
    }

    .back-btn:hover {
        background: #e2e8f0;
    }

    .preview-image {
        max-width: 150px;
        max-height: 150px;
        border-radius: 8px;
        margin-top: 0.5rem;
        display: none;
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <a href="{{ route('student.dashboard') }}" class="back-btn">← Back to Dashboard</a>

    <div class="profile-header">
        @if($student->profile_picture)
            <img src="{{ asset('storage/' . $student->profile_picture) }}" alt="{{ $student->name }}" class="profile-avatar">
        @else
            <div class="profile-avatar-placeholder">
                {{ strtoupper(substr($student->name, 0, 1)) }}
            </div>
        @endif
        <div class="profile-info">
            <h1>{{ $student->name }}</h1>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Course:</strong> {{ $student->course->name }}</p>
            @if($courseCompleted)
                <span class="progress-badge complete-badge">Course Completed</span>
            @else
                <span class="progress-badge">{{ $progressPercentage }}% Complete</span>
            @endif
        </div>
    </div>

    <div class="section-card">
        <h2>Completed Lessons ({{ $completedCount }}/{{ $totalVideos }})</h2>
        @if($completedVideos->count() > 0)
            <div class="video-list">
                @foreach($completedVideos as $progress)
                    <div class="video-item">
                        <div class="video-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <div class="video-details">
                            <h3>{{ $progress->video->title }}</h3>
                            <p>Completed on {{ $progress->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="text-align: center; color: #64748b; padding: 2rem;">
                No lessons completed yet. Start learning to track your progress!
            </p>
        @endif
    </div>

    <div class="section-card">
        <h2>Update Profile</h2>
        <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}" required>
                @error('email')
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

            <div class="form-group">
                <label for="current_password">Current Password (if changing password)</label>
                <input type="password" id="current_password" name="current_password">
                @error('current_password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password">
                <small>Minimum 8 characters</small>
                @error('new_password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">Confirm New Password</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation">
            </div>

            <button type="submit" class="update-btn">Update Profile</button>
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
