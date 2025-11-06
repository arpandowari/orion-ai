@extends('layouts.admin')

@section('title', 'Edit Video - Admin')

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

    .form-group textarea {
        min-height: 100px;
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

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('video_file');
    const fileInfo = document.getElementById('fileInfo');
    const form = document.getElementById('videoEditForm');
    const submitBtn = document.getElementById('submitBtn');

    // Show file info when selected
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                fileInfo.innerHTML = `<span style="color: #10b981;">✓ Selected: <strong>${file.name}</strong> (${sizeMB} MB)</span>`;
                
                // Check file size (500MB limit)
                if (file.size > 500 * 1024 * 1024) {
                    fileInfo.innerHTML = `<span style="color: #ef4444;">✗ File too large: ${sizeMB} MB (Max 500 MB)</span>`;
                    submitBtn.disabled = true;
                } else {
                    submitBtn.disabled = false;
                }
            }
        });
    }

    // Show file info when selected
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            fileInfo.textContent = `✓ Selected: ${file.name} (${sizeMB} MB)`;
            
            // Check file size (200MB limit based on server config)
            const maxSizeMB = 200;
            if (file.size > maxSizeMB * 1024 * 1024) {
                fileInfo.style.color = '#ef4444';
                fileInfo.textContent = `✗ File too large: ${sizeMB} MB (Max ${maxSizeMB} MB)`;
                submitBtn.disabled = true;
            } else {
                fileInfo.style.color = '#10b981';
                submitBtn.disabled = false;
            }
        }
    });

    // Handle form submission with progress
    form.addEventListener('submit', function(e) {
        const file = fileInput.files[0];
        
        // If no new file selected, use normal form submission
        if (!file) {
            return; // Let normal form submission happen
        }

        // Show progress indicator
        uploadProgress.style.display = 'block';
        submitBtn.disabled = true;
        cancelBtn.style.display = 'none';

        // For now, use normal form submission (more reliable)
        // The AJAX upload can be enabled later once we fix the server issue
        return; // Let form submit normally
        
        e.preventDefault();

        const formData = new FormData(form);
        
        // Show progress
        uploadProgress.style.display = 'block';
        submitBtn.disabled = true;
        cancelBtn.style.display = 'none';

        // Create XMLHttpRequest for progress tracking
        const xhr = new XMLHttpRequest();

        // Variables for speed calculation
        let startTime = Date.now();
        let lastLoaded = 0;
        let lastTime = Date.now();

        // Track upload progress
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const currentTime = Date.now();
                const percentComplete = (e.loaded / e.total) * 100;
                const loadedMB = (e.loaded / (1024 * 1024)).toFixed(2);
                const totalMB = (e.total / (1024 * 1024)).toFixed(2);
                
                // Calculate upload speed
                const timeDiff = (currentTime - lastTime) / 1000; // seconds
                const bytesDiff = e.loaded - lastLoaded;
                const speedMBps = (bytesDiff / (1024 * 1024)) / timeDiff;
                
                // Calculate average speed
                const totalTimeDiff = (currentTime - startTime) / 1000;
                const avgSpeedMBps = (e.loaded / (1024 * 1024)) / totalTimeDiff;
                
                // Calculate ETA
                const remainingBytes = e.total - e.loaded;
                const remainingMB = (remainingBytes / (1024 * 1024)).toFixed(2);
                const etaSeconds = remainingBytes / (avgSpeedMBps * 1024 * 1024);
                
                // Format ETA
                let etaText = '';
                if (etaSeconds < 60) {
                    etaText = `${Math.round(etaSeconds)}s`;
                } else if (etaSeconds < 3600) {
                    const minutes = Math.floor(etaSeconds / 60);
                    const seconds = Math.round(etaSeconds % 60);
                    etaText = `${minutes}m ${seconds}s`;
                } else {
                    const hours = Math.floor(etaSeconds / 3600);
                    const minutes = Math.floor((etaSeconds % 3600) / 60);
                    etaText = `${hours}h ${minutes}m`;
                }
                
                // Update progress bar
                progressBar.style.width = percentComplete + '%';
                
                // Update progress text with detailed info
                progressText.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-size: 1.25rem; font-weight: 700; color: #1e3a8a;">${Math.round(percentComplete)}%</span>
                        <span style="font-size: 0.875rem; color: #64748b;">ETA: ${etaText}</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-top: 0.5rem;">
                        <div style="text-align: center;">
                            <div style="font-size: 0.75rem; color: #64748b; margin-bottom: 0.25rem;">Uploaded</div>
                            <div style="font-size: 1rem; font-weight: 600; color: #10b981;">${loadedMB} MB</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 0.75rem; color: #64748b; margin-bottom: 0.25rem;">Total Size</div>
                            <div style="font-size: 1rem; font-weight: 600; color: #1e3a8a;">${totalMB} MB</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 0.75rem; color: #64748b; margin-bottom: 0.25rem;">Speed</div>
                            <div style="font-size: 1rem; font-weight: 600; color: #3b82f6;">${avgSpeedMBps.toFixed(2)} MB/s</div>
                        </div>
                    </div>
                `;
                
                // Update for next iteration
                lastLoaded = e.loaded;
                lastTime = currentTime;
            }
        });

        // Handle completion
        xhr.addEventListener('load', function() {
            if (xhr.status === 200 || xhr.status === 302) {
                progressBar.style.width = '100%';
                progressBar.style.background = 'linear-gradient(90deg, #10b981 0%, #059669 100%)';
                
                const totalTime = ((Date.now() - startTime) / 1000).toFixed(1);
                const totalMB = (file.size / (1024 * 1024)).toFixed(2);
                const avgSpeed = (totalMB / totalTime).toFixed(2);
                
                progressText.innerHTML = `
                    <div style="text-align: center; padding: 1rem;">
                        <div style="font-size: 2rem; margin-bottom: 0.5rem;">✓</div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: #10b981; margin-bottom: 0.5rem;">Upload Complete!</div>
                        <div style="font-size: 0.875rem; color: #64748b;">
                            Uploaded ${totalMB} MB in ${totalTime}s (${avgSpeed} MB/s average)
                        </div>
                        <div style="font-size: 0.875rem; color: #64748b; margin-top: 0.5rem;">
                            Redirecting to dashboard...
                        </div>
                    </div>
                `;
                
                // Redirect to dashboard
                setTimeout(function() {
                    window.location.href = '{{ route("admin.dashboard") }}';
                }, 2000);
            } else {
                uploadProgress.style.display = 'none';
                submitBtn.disabled = false;
                cancelBtn.style.display = 'inline-block';
                alert('Upload failed. Please try again.');
            }
        });

        // Handle load end (catches all completion states)
        xhr.addEventListener('loadend', function() {
            if (xhr.status !== 200 && xhr.status !== 302 && xhr.status !== 0) {
                uploadProgress.style.display = 'none';
                submitBtn.disabled = false;
                cancelBtn.style.display = 'inline-block';
                
                let errorMsg = 'Upload failed (Status: ' + xhr.status + '). ';
                try {
                    const response = JSON.parse(xhr.responseText);
                    errorMsg += response.message || response.error || 'Please try again.';
                } catch(e) {
                    if (xhr.status === 413) {
                        errorMsg = 'File too large! The server rejected the upload. Please use a smaller file or contact administrator.';
                    } else if (xhr.status === 500) {
                        errorMsg = 'Server error. Please check the Laravel logs or try again.';
                    } else if (xhr.status === 0) {
                        errorMsg = 'Network error. Please check your connection.';
                    } else {
                        errorMsg += 'Response: ' + xhr.responseText.substring(0, 200);
                    }
                }
                console.error('Upload error:', errorMsg);
                console.error('Status:', xhr.status);
                console.error('Response:', xhr.responseText);
                alert(errorMsg);
            }
        });
        
        // Handle errors
        xhr.addEventListener('error', function() {
            console.error('XHR Error event triggered');
            console.error('Status:', xhr.status);
            console.error('Response:', xhr.responseText);
        });
        
        // Handle timeout
        xhr.addEventListener('timeout', function() {
            uploadProgress.style.display = 'none';
            submitBtn.disabled = false;
            cancelBtn.style.display = 'inline-block';
            alert('Upload timeout. The file may be too large. Please try a smaller file.');
        });
        
        // Set timeout to 10 minutes
        xhr.timeout = 600000;

        // Send request
        xhr.open('POST', form.action);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(formData);
    });
});
</script>
@endsection
@section('content')
<div class="form-container">
        <div class="form-header">
            <h1>Edit Video</h1>
            <p>Update video information</p>
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

        <form method="POST" action="{{ route('admin.videos.update', $video->id) }}" enctype="multipart/form-data" id="videoEditForm">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="course_id">Course *</label>
                <select id="course_id" name="course_id" required>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ $video->course_id == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="title">Video Title *</label>
                <input type="text" id="title" name="title" required value="{{ old('title', $video->title) }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description', $video->description) }}</textarea>
            </div>

            @if($video->video_path)
                <div class="form-group">
                    <label>Current Video</label>
                    <div style="background: #f1f5f9; padding: 1rem; border-radius: 8px; border: 2px solid #e2e8f0;">
                        <p style="margin: 0; color: #1e3a8a; font-weight: 600;">📹 {{ basename($video->video_path) }}</p>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem; color: #64748b;">Path: {{ $video->video_path }}</p>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label for="video_file">Upload New Video File (Optional)</label>
                <input type="file" id="video_file" name="video_file" accept="video/*">
                <div class="help-text">Select a video file from your device to upload and replace the current video</div>
                <div id="fileInfo" style="margin-top: 0.5rem; font-size: 0.875rem;"></div>
            </div>

            <div class="form-group">
                <label for="order">Video Order *</label>
                <input type="number" id="order" name="order" required value="{{ old('order', $video->order) }}" min="1">
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="is_free" name="is_free" {{ $video->is_free ? 'checked' : '' }}>
                    <label for="is_free" style="margin: 0;">Free (accessible without enrollment)</label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-cancel" id="cancelBtn">Cancel</a>
                <button type="submit" class="btn-submit" id="submitBtn">Update Video</button>
            </div>
        </form>
    </div>
@endsection
