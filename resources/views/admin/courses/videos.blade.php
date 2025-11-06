@extends('layouts.admin')

@section('title', 'Manage Videos - ' . $course->name)

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .btn-add {
        background: var(--success);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
    }

    .video-list {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .video-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: var(--light);
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .video-info {
        flex: 1;
    }

    .video-title {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
    }

    .video-meta {
        font-size: 0.875rem;
        color: #64748b;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }

    .status-free {
        background: #d1fae5;
        color: #065f46;
    }

    .status-locked {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-btns {
        display: flex;
        gap: 0.5rem;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
    }

    .btn-edit {
        background: #3b82f6;
        color: white;
    }

    .btn-delete {
        background: #ef4444;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="page-header">
        <h1>{{ $course->name }}</h1>
        <p>Manage videos for this course</p>
    </div>

    <div class="action-bar">
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background: #64748b; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none;">← Back to Dashboard</a>
        <a href="{{ route('admin.videos.create') }}?course_id={{ $course->id }}" class="btn-add">➕ Add Video</a>
    </div>

    <div class="video-list">
        <h2 style="color: var(--primary); margin-bottom: 1.5rem;">Videos ({{ $course->videos->count() }})</h2>

        @forelse($course->videos->sortBy('order') as $video)
            <div class="video-item">
                <div class="video-info">
                    <div class="video-title">
                        {{ $video->order }}. {{ $video->title }}
                        <span class="status-badge {{ $video->is_free ? 'status-free' : 'status-locked' }}">
                            {{ $video->is_free ? 'FREE' : 'LOCKED' }}
                        </span>
                    </div>
                    <div class="video-meta">
                        {{ Str::limit($video->description, 100) }}
                    </div>
                    <div class="video-meta" style="margin-top: 0.25rem;">
                        URL: {{ Str::limit($video->video_url, 60) }}
                    </div>
                </div>
                <div class="action-btns">
                    <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn-sm btn-edit">Edit</a>
                    <form method="POST" action="{{ route('admin.videos.destroy', $video->id) }}" style="display: inline;" onsubmit="return confirm('Delete this video?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sm btn-delete">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p style="text-align: center; color: #64748b; padding: 2rem;">No videos yet. Add your first video!</p>
        @endforelse
    </div>
</div>
@endsection
