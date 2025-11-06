@extends('layouts.app')

@section('title', $course->name . ' - ORION AI')

@section('styles')
<style>
    .course-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        max-width: 100%;
    }

    .course-header h1 {
        margin-bottom: 0.5rem;
        font-size: 1.75rem;
        word-wrap: break-word;
    }
    
    .course-header p {
        margin: 0;
        opacity: 0.95;
    }

    .course-layout {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(300px, 380px);
        gap: 1.5rem;
        max-width: 100%;
        align-items: start;
    }

    .video-section {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        max-width: 100%;
        min-width: 0;
        overflow: hidden;
        width: 100%;
    }

    /* Custom Video Player Styles */
    .custom-video-container {
        position: relative;
        width: 100%;
        max-width: 100%;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        background: #000;
        border-radius: 8px;
        margin-bottom: 1rem;
        overflow: hidden;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    }

    .custom-video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
        background: #000;
    }

    /* Hide ALL default video controls */
    .custom-video-container video::-webkit-media-controls {
        display: none !important;
    }

    .custom-video-container video::-webkit-media-controls-enclosure {
        display: none !important;
    }

    .custom-video-container video::-webkit-media-controls-panel {
        display: none !important;
    }

    .custom-video-container video::-webkit-media-controls-play-button {
        display: none !important;
    }

    .custom-video-container video::-webkit-media-controls-start-playback-button {
        display: none !important;
    }

    .custom-video-container video::-moz-media-controls {
        display: none !important;
    }

    .custom-video-container video::--webkit-media-controls-overlay-play-button {
        display: none !important;
    }

    .custom-video-container video::-webkit-media-controls {
        display: none !important;
    }

    .custom-video-container video::-webkit-media-controls-enclosure {
        display: none !important;
    }

    .video-controls {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.7) 50%, transparent 100%);
        padding: 1.5rem 1.5rem 1rem 1.5rem;
        opacity: 1;
        transition: opacity 0.3s ease;
        z-index: 10;
    }

    .custom-video-container.playing .video-controls {
        opacity: 0;
    }

    .custom-video-container:hover .video-controls,
    .video-controls.show {
        opacity: 1;
    }

    .progress-bar-container {
        width: 100%;
        height: 5px;
        background: rgba(255,255,255,0.25);
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 1rem;
        position: relative;
        transition: height 0.2s;
    }

    .progress-bar-container:hover {
        height: 7px;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        width: 0%;
        transition: width 0.1s;
        position: relative;
        z-index: 2;
    }

    .progress-buffer {
        position: absolute;
        height: 100%;
        background: rgba(255,255,255,0.4);
        border-radius: 10px;
        width: 0%;
        z-index: 1;
    }

    .controls-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .control-btn {
        background: rgba(255,255,255,0.1);
        border: none;
        color: white;
        font-size: 1.1rem;
        cursor: pointer;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s ease;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
    }

    .control-btn:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }

    .control-btn:active {
        transform: translateY(0);
        background: rgba(255,255,255,0.15);
    }

    .time-display {
        color: white;
        font-size: 0.875rem;
        font-weight: 600;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.5px;
        padding: 0 0.5rem;
    }

    .volume-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0 0.5rem;
    }

    .volume-slider {
        width: 80px;
        height: 4px;
        -webkit-appearance: none;
        background: rgba(255,255,255,0.3);
        border-radius: 10px;
        outline: none;
        cursor: pointer;
    }

    .volume-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 14px;
        height: 14px;
        background: white;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        transition: transform 0.2s;
    }

    .volume-slider::-webkit-slider-thumb:hover {
        transform: scale(1.2);
    }

    .volume-slider::-moz-range-thumb {
        width: 14px;
        height: 14px;
        background: white;
        border-radius: 50%;
        cursor: pointer;
        border: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .playback-speed {
        color: white;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        min-width: 70px;
        text-align: center;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='white' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.5rem center;
        padding-right: 2rem;
    }

    .playback-speed:hover {
        background: rgba(255,255,255,0.25);
        border-color: rgba(255,255,255,0.4);
    }

    .playback-speed:focus {
        outline: none;
        border-color: rgba(255,255,255,0.6);
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
    }

    .playback-speed option {
        background: #1e293b;
        color: white;
        padding: 0.5rem;
        font-weight: 600;
    }

    .spacer {
        flex: 1;
    }

    .video-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        border: 5px solid rgba(255,255,255,0.2);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        display: none;
    }

    .video-loading.show {
        display: block;
    }

    @keyframes spin {
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .volume-control {
            display: none;
        }
    }

    .video-info {
        max-width: 100%;
        overflow: hidden;
    }
    
    .video-info h2 {
        color: var(--primary);
        margin-bottom: 0.5rem;
        font-size: 1.5rem;
        word-wrap: break-word;
    }

    .video-info p {
        color: #64748b;
        word-wrap: break-word;
    }

    .playlist {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        max-width: 100%;
        min-width: 0;
        overflow: hidden;
        position: sticky;
        top: 90px;
        max-height: calc(100vh - 110px);
        overflow-y: auto;
    }

    .playlist h3 {
        color: var(--primary);
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .completion-badge {
        background: var(--success);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
    }

    .video-item {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        border: 2px solid transparent;
    }

    .video-item:hover {
        background: var(--light);
    }

    .video-item.active {
        background: var(--light);
        border-color: var(--secondary);
    }

    .video-item.locked {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .video-item.locked:hover {
        background: white;
    }

    .video-icon {
        font-size: 1.5rem;
        min-width: 30px;
        text-align: center;
    }

    .video-icon.free {
        color: var(--success);
    }

    .video-icon.locked {
        color: #94a3b8;
    }

    .video-icon.completed {
        color: var(--success);
    }

    .video-details {
        flex: 1;
    }

    .video-title {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 0.25rem;
        word-wrap: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .video-duration {
        font-size: 0.875rem;
        color: #64748b;
    }

    .locked-message {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
    }

    .locked-message h4 {
        color: #92400e;
        margin-bottom: 0.5rem;
    }

    .locked-message p {
        color: #78350f;
        margin-bottom: 1rem;
    }

    .mark-complete-btn {
        margin-top: 1rem;
        width: 100%;
    }

    @media (max-width: 1100px) {
        .course-layout {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .playlist {
            position: static;
            max-height: none;
        }
    }
    
    @media (max-width: 768px) {
        .course-layout {
            gap: 1rem;
        }
        
        .video-section {
            padding: 1rem;
        }
        
        .playlist {
            padding: 1rem;
        }
        
        .course-header {
            padding: 1.5rem;
        }
        
        .course-header h1 {
            font-size: 1.5rem;
        }
        
        .control-btn {
            padding: 0.4rem 0.6rem;
            font-size: 1rem;
            min-width: 32px;
            height: 32px;
        }
        
        .time-display {
            font-size: 0.75rem;
        }
        
        .playback-speed {
            font-size: 0.75rem;
            padding: 0.3rem 0.5rem;
        }
    }
    
    @media (max-width: 480px) {
        .container {
            padding: 1rem !important;
        }
        
        .video-section {
            padding: 0.75rem;
        }
        
        .playlist {
            padding: 0.75rem;
        }
        
        .course-header {
            padding: 1rem;
        }
        
        .course-header h1 {
            font-size: 1.25rem;
        }
    }
    
    /* Ensure container doesn't overflow */
    body {
        overflow-x: hidden;
    }
    
    .container {
        max-width: 100%;
        overflow-x: hidden;
    }
</style>
@endsection

@section('content')
<div class="container" style="max-width: 1300px; padding: 1.5rem;">
    <div class="course-header">
        <h1>{{ $course->name }}</h1>
        <p>{{ $course->description }}</p>
    </div>

    <div class="course-layout">
        <div class="video-section">
            @if($currentVideo)
                @if($currentVideo->is_free || $hasAccess)
                    @if($currentVideo->video_path)
                        <div class="custom-video-container" id="videoContainer">
                            <video id="customVideo" preload="metadata" playsinline>
                                <source src="{{ asset('storage/' . $currentVideo->video_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>

                            <div class="video-loading" id="videoLoading"></div>

                            <div class="video-controls" id="videoControls">
                                <div class="progress-bar-container" id="progressContainer">
                                    <div class="progress-buffer" id="progressBuffer"></div>
                                    <div class="progress-bar" id="progressBar"></div>
                                </div>
                                <div class="controls-row">
                                    <button type="button" class="control-btn" id="playPauseBtn" title="Play/Pause (Space)" onclick="toggleVideoPlay(); return false;">
                                        <span id="playIcon">▶</span>
                                    </button>
                                    <button type="button" class="control-btn" id="rewindBtn" title="Rewind 5s (←)" onclick="skipVideo(-5); return false;">
                                        <span>⏪</span>
                                    </button>
                                    <button type="button" class="control-btn" id="forwardBtn" title="Forward 5s (→)" onclick="skipVideo(5); return false;">
                                        <span>⏩</span>
                                    </button>
                                    <div class="time-display">
                                        <span id="currentTime">0:00</span> / <span id="duration">0:00</span>
                                    </div>
                                    <div class="volume-control">
                                        <button type="button" class="control-btn" id="muteBtn" title="Mute/Unmute">
                                            <span id="volumeIcon">🔊</span>
                                        </button>
                                        <input type="range" class="volume-slider" id="volumeSlider" min="0" max="100" value="100">
                                    </div>
                                    <select class="playback-speed" id="speedControl">
                                        <option value="0.5">0.5x</option>
                                        <option value="0.75">0.75x</option>
                                        <option value="1" selected>1x</option>
                                        <option value="1.25">1.25x</option>
                                        <option value="1.5">1.5x</option>
                                        <option value="2">2x</option>
                                    </select>
                                    <div class="spacer"></div>
                                    <button type="button" class="control-btn" id="fullscreenBtn" title="Fullscreen">
                                        <span>⛶</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div style="width: 100%; aspect-ratio: 16/9; background: #000; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                            <div style="text-align: center;">
                                <h3>Video not available</h3>
                            </div>
                        </div>
                    @endif
                    
                    <div class="video-info">
                        <h2>{{ $currentVideo->title }}</h2>
                        <p>{{ $currentVideo->description }}</p>
                    </div>

                    @if(auth()->guard('student')->check() || auth()->check())
                        @if(!$isCompleted)
                            <form method="POST" action="{{ route('video.complete', $currentVideo->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary mark-complete-btn">
                                    Mark as Completed
                                </button>
                            </form>
                        @else
                            <div style="text-align: center; padding: 1rem; background: var(--light); border-radius: 8px; color: var(--success); font-weight: 600;">
                                ✓ Completed
                            </div>
                        @endif
                    @endif
                @else
                    <div style="width: 100%; aspect-ratio: 16/9; background: #000; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                        <div style="text-align: center;">
                            <h3>🔒 This video is locked</h3>
                        </div>
                    </div>

                    <div class="locked-message">
                        <h4>Premium Content</h4>
                        <p>This video is part of our premium content. Register for this course to unlock all videos.</p>
                        <a href="{{ route('registration.create', $course->id) }}" class="btn btn-primary" style="width: 100%;">
                            Enroll Now to Unlock
                        </a>
                    </div>
                @endif
            @else
                <div style="width: 100%; aspect-ratio: 16/9; background: #000; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                    <div style="text-align: center;">
                        <h3>Select a video to start</h3>
                    </div>
                </div>
            @endif
        </div>

        <div class="playlist">
            <h3>
                Course Content
                @if($courseCompleted)
                    <span class="completion-badge">✓ Completed</span>
                @endif
            </h3>

            @foreach($course->videos as $video)
                <div class="video-item {{ $currentVideo && $currentVideo->id == $video->id ? 'active' : '' }} {{ !$video->is_free && !$hasAccess ? 'locked' : '' }}"
                     onclick="{{ $video->is_free || $hasAccess ? 'window.location.href=\'' . route('courses.show', ['id' => $course->id, 'video' => $video->id]) . '\'' : 'return false;' }}">
                    
                    <div class="video-icon {{ $video->is_free ? 'free' : ($hasAccess ? '' : 'locked') }} {{ isset($completedVideos[$video->id]) ? 'completed' : '' }}">
                        @if(isset($completedVideos[$video->id]))
                            ✓
                        @elseif($video->is_free)
                            ▶
                        @elseif($hasAccess)
                            ▶
                        @else
                            🔒
                        @endif
                    </div>

                    <div class="video-details">
                        <div class="video-title">
                            {{ $video->title }}
                            @if($video->is_free)
                                <span style="color: var(--success); font-size: 0.75rem; font-weight: 600;">(FREE)</span>
                            @endif
                        </div>
                        <div class="video-duration">
                            @if($video->is_free || $hasAccess)
                                Lesson {{ $video->order }}
                            @else
                                Locked - Enroll to access
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @if(!$hasAccess)
                <div style="margin-top: 1.5rem; padding: 1rem; background: var(--light); border-radius: 8px; text-align: center;">
                    <p style="color: #64748b; margin-bottom: 1rem;">Unlock all {{ $course->videos->count() }} videos</p>
                    <a href="{{ route('registration.create', $course->id) }}" class="btn btn-primary" style="width: 100%;">
                        Enroll in Course
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@if($currentVideo && $currentVideo->video_path && ($currentVideo->is_free || $hasAccess))
<script>
// Global video player functions
let videoPlayer = null;

function toggleVideoPlay() {
    if (!videoPlayer) videoPlayer = document.getElementById('customVideo');
    const playIcon = document.getElementById('playIcon');
    
    if (videoPlayer.paused) {
        videoPlayer.play().catch(e => console.error('Play error:', e));
        playIcon.textContent = '⏸';
    } else {
        videoPlayer.pause();
        playIcon.textContent = '▶';
    }
    return false;
}

function skipVideo(seconds) {
    if (!videoPlayer) videoPlayer = document.getElementById('customVideo');
    
    try {
        // Store current state
        const wasPlaying = !videoPlayer.paused;
        const oldTime = videoPlayer.currentTime;
        
        // Calculate new time
        let newTime = oldTime + seconds;
        if (newTime < 0) newTime = 0;
        if (newTime > videoPlayer.duration) newTime = videoPlayer.duration;
        
        // Set new time
        videoPlayer.currentTime = newTime;
        
        // Resume playing if it was playing
        if (wasPlaying) {
            setTimeout(() => {
                videoPlayer.play().catch(e => console.error('Resume error:', e));
            }, 50);
        }
        
        console.log('Skip:', seconds, 'seconds | From:', oldTime.toFixed(2), 'To:', newTime.toFixed(2));
    } catch (error) {
        console.error('Skip error:', error);
    }
    
    return false;
}

document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('customVideo');
    const container = document.getElementById('videoContainer');
    const controls = document.getElementById('videoControls');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const playIcon = document.getElementById('playIcon');
    const rewindBtn = document.getElementById('rewindBtn');
    const forwardBtn = document.getElementById('forwardBtn');
    const progressBar = document.getElementById('progressBar');
    const progressBuffer = document.getElementById('progressBuffer');
    const progressContainer = document.getElementById('progressContainer');
    const currentTimeEl = document.getElementById('currentTime');
    const durationEl = document.getElementById('duration');
    const volumeSlider = document.getElementById('volumeSlider');
    const muteBtn = document.getElementById('muteBtn');
    const volumeIcon = document.getElementById('volumeIcon');
    const speedControl = document.getElementById('speedControl');
    const fullscreenBtn = document.getElementById('fullscreenBtn');
    const videoLoading = document.getElementById('videoLoading');
    
    console.log('Video player initialized');
    console.log('Rewind button:', rewindBtn);
    console.log('Forward button:', forwardBtn);

    let controlsTimeout;

    // Prevent right-click and download
    video.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        return false;
    });

    video.removeAttribute('download');
    video.controlsList = 'nodownload noremoteplayback';

    // Play/Pause
    function togglePlay() {
        if (video.paused) {
            video.play();
            playIcon.textContent = '⏸';
        } else {
            video.pause();
            playIcon.textContent = '▶';
        }
    }

    // Video click to play/pause
    video.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleVideoPlay();
    });
    
    // Update icon when video state changes
    video.addEventListener('play', function() {
        playIcon.textContent = '⏸';
    });
    
    video.addEventListener('pause', function() {
        playIcon.textContent = '▶';
    });

    // Update progress
    video.addEventListener('timeupdate', () => {
        const progress = (video.currentTime / video.duration) * 100;
        progressBar.style.width = progress + '%';
        currentTimeEl.textContent = formatTime(video.currentTime);
    });

    // Update buffer
    video.addEventListener('progress', () => {
        if (video.buffered.length > 0) {
            const buffered = (video.buffered.end(video.buffered.length - 1) / video.duration) * 100;
            progressBuffer.style.width = buffered + '%';
        }
    });

    // Set duration
    video.addEventListener('loadedmetadata', () => {
        durationEl.textContent = formatTime(video.duration);
    });

    // Seek
    progressContainer.addEventListener('click', (e) => {
        const rect = progressContainer.getBoundingClientRect();
        const pos = (e.clientX - rect.left) / rect.width;
        video.currentTime = pos * video.duration;
    });

    // Volume
    volumeSlider.addEventListener('input', (e) => {
        video.volume = e.target.value / 100;
        updateVolumeIcon();
    });

    muteBtn.addEventListener('click', () => {
        video.muted = !video.muted;
        updateVolumeIcon();
    });

    function updateVolumeIcon() {
        if (video.muted || video.volume === 0) {
            volumeIcon.textContent = '🔇';
        } else if (video.volume < 0.5) {
            volumeIcon.textContent = '🔉';
        } else {
            volumeIcon.textContent = '🔊';
        }
    }

    // Playback speed
    speedControl.addEventListener('change', (e) => {
        video.playbackRate = parseFloat(e.target.value);
    });

    // Fullscreen
    fullscreenBtn.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            container.requestFullscreen();
        } else {
            document.exitFullscreen();
        }
    });

    // Show/hide controls
    container.addEventListener('mousemove', () => {
        controls.classList.add('show');
        clearTimeout(controlsTimeout);
        if (!video.paused) {
            controlsTimeout = setTimeout(() => {
                controls.classList.remove('show');
            }, 3000);
        }
    });

    container.addEventListener('mouseleave', () => {
        if (!video.paused) {
            controls.classList.remove('show');
        }
    });

    // Loading
    video.addEventListener('waiting', () => {
        videoLoading.classList.add('show');
    });

    video.addEventListener('canplay', () => {
        videoLoading.classList.remove('show');
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        
        switch(e.key) {
            case ' ':
            case 'k':
                e.preventDefault();
                togglePlay();
                break;
            case 'ArrowLeft':
                e.preventDefault();
                video.currentTime = Math.max(0, video.currentTime - 5);
                break;
            case 'ArrowRight':
                e.preventDefault();
                video.currentTime = Math.min(video.duration, video.currentTime + 5);
                break;
            case 'ArrowUp':
                e.preventDefault();
                video.volume = Math.min(1, video.volume + 0.1);
                volumeSlider.value = video.volume * 100;
                updateVolumeIcon();
                break;
            case 'ArrowDown':
                e.preventDefault();
                video.volume = Math.max(0, video.volume - 0.1);
                volumeSlider.value = video.volume * 100;
                updateVolumeIcon();
                break;
            case 'm':
                e.preventDefault();
                video.muted = !video.muted;
                updateVolumeIcon();
                break;
            case 'f':
                e.preventDefault();
                fullscreenBtn.click();
                break;
        }
    });

    // Format time
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    }

    // Prevent download
    video.addEventListener('loadstart', () => {
        video.setAttribute('controlsList', 'nodownload noremoteplayback');
    });
});
</script>
@endif
