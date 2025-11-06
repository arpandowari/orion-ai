<div class="custom-video-container" id="videoContainer">
    <video id="customVideo" preload="metadata" playsinline controlsList="nodownload noremoteplayback" disablePictureInPicture>
        <source src="{{ $src }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>



    <div class="video-loading" id="videoLoading"></div>

    <div class="video-controls" id="videoControls">
        <div class="progress-bar-container" id="progressContainer">
            <div class="progress-buffer" id="progressBuffer"></div>
            <div class="progress-bar" id="progressBar"></div>
        </div>
        <div class="controls-row">
            <button class="control-btn" id="playPauseBtn" title="Play/Pause (Space)">
                <span id="playIcon">▶</span>
            </button>
            <button class="control-btn" id="rewindBtn" title="Rewind 5s (←)">
                <span>⏪</span>
            </button>
            <button class="control-btn" id="forwardBtn" title="Forward 5s (→)">
                <span>⏩</span>
            </button>
            <div class="time-display">
                <span id="currentTime">0:00</span> / <span id="duration">0:00</span>
            </div>
            <div class="volume-control">
                <button class="control-btn" id="muteBtn" title="Mute/Unmute">
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
            <button class="control-btn" id="fullscreenBtn" title="Fullscreen">
                <span>⛶</span>
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';
    
    // Wait a bit for DOM to be ready
    setTimeout(function() {
        const video = document.getElementById('customVideo');
        const container = document.getElementById('videoContainer');
        const controls = document.getElementById('videoControls');
        const playPauseBtn = document.getElementById('playPauseBtn');
        const playIcon = document.getElementById('playIcon');
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
        const rewindBtn = document.getElementById('rewindBtn');
        const forwardBtn = document.getElementById('forwardBtn');

        // Check if elements exist
        if (!video || !container || !controls) {
            console.error('Video player elements not found');
            return;
        }

        let controlsTimeout;

    // Prevent right-click and disable default controls
    video.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        return false;
    });

    // Force remove controls
    video.removeAttribute('controls');
    video.controls = false;
    
    // Prevent download
    video.addEventListener('loadstart', function() {
        this.removeAttribute('controls');
        this.controls = false;
    });

    // Play/Pause
    function togglePlay() {
        if (video.paused) {
            video.play();
            playIcon.textContent = '⏸';
            container.classList.add('playing');
        } else {
            video.pause();
            playIcon.textContent = '▶';
            container.classList.remove('playing');
        }
    }

    playPauseBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        togglePlay();
    });
    
    video.addEventListener('click', function(e) {
        e.stopPropagation();
        togglePlay();
    });
    
    // Update icon when video plays
    video.addEventListener('play', function() {
        playIcon.textContent = '⏸';
        container.classList.add('playing');
    });
    
    // Update icon when video pauses
    video.addEventListener('pause', function() {
        playIcon.textContent = '▶';
        container.classList.remove('playing');
    });
    
    // Also check initial state
    if (!video.paused) {
        playIcon.textContent = '⏸';
        container.classList.add('playing');
    }

    // Skip buttons
    rewindBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (!isNaN(video.duration) && video.duration > 0) {
            const newTime = Math.max(0, video.currentTime - 5);
            isSeeking = true;
            targetTime = newTime;
            video.currentTime = newTime;
        }
    });

    forwardBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (!isNaN(video.duration) && video.duration > 0) {
            const newTime = Math.min(video.duration, video.currentTime + 5);
            isSeeking = true;
            targetTime = newTime;
            video.currentTime = newTime;
        }
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
    let isSeeking = false;
    let targetTime = 0;
    
    progressContainer.addEventListener('click', function(e) {
        e.stopPropagation();
        const rect = progressContainer.getBoundingClientRect();
        const pos = (e.clientX - rect.left) / rect.width;
        if (!isNaN(video.duration) && video.duration > 0) {
            isSeeking = true;
            targetTime = pos * video.duration;
            video.currentTime = targetTime;
        }
    });
    
    // Handle seeking events
    video.addEventListener('seeking', function() {
        videoLoading.classList.add('show');
    });
    
    video.addEventListener('seeked', function() {
        videoLoading.classList.remove('show');
        isSeeking = false;
        // Ensure video is at the correct position
        if (Math.abs(video.currentTime - targetTime) > 0.5) {
            video.currentTime = targetTime;
        }
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
                if (!isNaN(video.duration) && video.duration > 0) {
                    const newTime = Math.max(0, video.currentTime - 5);
                    isSeeking = true;
                    targetTime = newTime;
                    video.currentTime = newTime;
                }
                break;
            case 'ArrowRight':
                e.preventDefault();
                if (!isNaN(video.duration) && video.duration > 0) {
                    const newTime = Math.min(video.duration, video.currentTime + 5);
                    isSeeking = true;
                    targetTime = newTime;
                    video.currentTime = newTime;
                }
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
        if (isNaN(seconds)) return '0:00';
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    }
    
        // Initialize
        updateVolumeIcon();
        console.log('Video player initialized successfully');
    }, 100); // Wait 100ms for DOM
})();
</script>
