<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Video;
use App\Models\Registration;
use App\Models\PlacementEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class AdminCourseController extends Controller
{
    private function checkAdmin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access');
        }
    }

    public function dashboard()
    {
        $this->checkAdmin();

        $courses = Course::with(['videos', 'registrations'])->get();
        $allVideos = Video::with('course')->orderBy('course_id')->orderBy('order')->get();
        $registrations = Registration::with('course')->latest()->get();
        $placements = PlacementEnrollment::latest()->get();
        $totalVideos = Video::count();
        
        return view('admin.dashboard-professional', compact('courses', 'allVideos', 'registrations', 'placements', 'totalVideos'));
    }

    public function analytics()
    {
        $this->checkAdmin();

        $registrations = Registration::with('course')->latest()->get();
        $placements = PlacementEnrollment::latest()->get();
        
        return view('admin.analytics', compact('registrations', 'placements'));
    }

    // Course CRUD
    public function createCourse()
    {
        $this->checkAdmin();
        return view('admin.courses.create');
    }

    public function storeCourse(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'syllabus' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Handle checkbox - convert to boolean
        $validated['is_active'] = $request->has('is_active') ? true : false;

        Course::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Course created successfully!');
    }

    public function editCourse($id)
    {
        $this->checkAdmin();
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    public function updateCourse(Request $request, $id)
    {
        $this->checkAdmin();

        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'syllabus' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Handle checkbox - convert to boolean
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $course->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Course updated successfully!');
    }

    public function destroyCourse($id)
    {
        $this->checkAdmin();

        $course = Course::findOrFail($id);
        
        // Delete all videos
        $course->videos()->delete();
        
        // Delete thumbnail
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        
        $course->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Course deleted successfully!');
    }

    // Video CRUD
    public function courseVideos($courseId)
    {
        $this->checkAdmin();
        $course = Course::with('videos')->findOrFail($courseId);
        return view('admin.courses.videos', compact('course'));
    }

    public function createVideo()
    {
        $this->checkAdmin();
        $courses = Course::all();
        return view('admin.videos.create', compact('courses'));
    }

    public function storeVideo(Request $request)
    {
        $this->checkAdmin();

        try {
            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'video_file' => 'required|file|mimes:mp4,mov,avi,wmv,flv,mkv,webm|max:512000', // Max 500MB
                'order' => 'required|integer|min:1'
            ]);

            // Handle video file upload
            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                
                // Check if file uploaded successfully
                if (!$file->isValid()) {
                    throw new \Exception('File upload failed. Please try again.');
                }
                
                // Create videos directory if it doesn't exist
                $videosPath = storage_path('app/public/videos');
                if (!file_exists($videosPath)) {
                    mkdir($videosPath, 0755, true);
                }
                
                // Store file and get path
                $path = $file->store('videos', 'public');
                
                // Verify file was actually saved
                if (!Storage::disk('public')->exists($path)) {
                    throw new \Exception('File was not saved to storage. Path: ' . $path);
                }
                
                $validated['video_path'] = $path;
                
                \Log::info('Video file stored successfully', [
                    'path' => $path,
                    'full_path' => Storage::disk('public')->path($path),
                    'exists' => Storage::disk('public')->exists($path)
                ]);
            } else {
                throw new \Exception('No video file was uploaded.');
            }
            
            // Remove video_file from validated data
            unset($validated['video_file']);

            // Handle checkbox - convert to boolean
            $validated['is_free'] = $request->has('is_free') ? true : false;

            $video = Video::create($validated);
            
            \Log::info('Video record created', [
                'id' => $video->id,
                'video_path' => $video->video_path
            ]);

            // Return JSON for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Video added successfully!']);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Video added successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Video validation failed', ['errors' => $e->validator->errors()->all()]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Video upload failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Upload failed: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->withInput()->with('error', 'Failed to add video: ' . $e->getMessage());
        }
    }

    public function editVideo($id)
    {
        $this->checkAdmin();
        $video = Video::findOrFail($id);
        $courses = Course::all();
        return view('admin.videos.edit', compact('video', 'courses'));
    }

    public function updateVideo(Request $request, $id)
    {
        $this->checkAdmin();

        try {
            $video = Video::findOrFail($id);

            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv,flv,mkv,webm|max:512000', // Max 500MB
                'order' => 'required|integer|min:1'
            ]);

            // Handle video file upload if new file provided
            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                
                // Check if file uploaded successfully
                if (!$file->isValid()) {
                    throw new \Exception('File upload failed. Please try again.');
                }
                
                // Create videos directory if it doesn't exist
                $videosPath = storage_path('app/public/videos');
                if (!file_exists($videosPath)) {
                    mkdir($videosPath, 0755, true);
                }
                
                // Delete old video file if exists
                if ($video->video_path && Storage::disk('public')->exists($video->video_path)) {
                    Storage::disk('public')->delete($video->video_path);
                    \Log::info('Deleted old video file', ['path' => $video->video_path]);
                }
                
                // Store new file and get path
                $path = $file->store('videos', 'public');
                
                // Verify file was actually saved
                if (!Storage::disk('public')->exists($path)) {
                    throw new \Exception('File was not saved to storage. Path: ' . $path);
                }
                
                $validated['video_path'] = $path;
                
                \Log::info('Video file updated successfully', [
                    'path' => $path,
                    'full_path' => Storage::disk('public')->path($path),
                    'exists' => Storage::disk('public')->exists($path)
                ]);
            }
            
            // Remove video_file from validated data
            unset($validated['video_file']);

            // Handle checkbox - convert to boolean
            $validated['is_free'] = $request->has('is_free') ? true : false;

            $video->update($validated);
            
            \Log::info('Video record updated', [
                'id' => $video->id,
                'video_path' => $video->video_path
            ]);

            // Return JSON for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Video updated successfully!']);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Video updated successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Video validation failed', ['errors' => $e->validator->errors()->all()]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Video update failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Upload failed: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->withInput()->with('error', 'Failed to update video: ' . $e->getMessage());
        }
    }

    public function destroyVideo($id)
    {
        $this->checkAdmin();

        $video = Video::findOrFail($id);
        
        // Delete video file if exists
        if ($video->video_path) {
            Storage::disk('public')->delete($video->video_path);
        }
        
        $video->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Video deleted successfully!');
    }

    // Student Management
    public function unlockCourse($id)
    {
        $this->checkAdmin();

        try {
            $registration = Registration::findOrFail($id);
            
            \Log::info('Unlocking course for registration ID: ' . $id);
            \Log::info('Current status: ' . ($registration->course_unlocked ? 'unlocked' : 'locked'));
            
            $registration->course_unlocked = true;
            $saved = $registration->save();
            
            \Log::info('Save result: ' . ($saved ? 'success' : 'failed'));
            \Log::info('New status: ' . ($registration->course_unlocked ? 'unlocked' : 'locked'));
            
            return redirect()->back()->with('success', 'Course unlocked successfully for ' . $registration->name . '!');
        } catch (\Exception $e) {
            \Log::error('Failed to unlock course: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to unlock course: ' . $e->getMessage());
        }
    }

    public function toggleCourseLock($id)
    {
        $this->checkAdmin();

        try {
            $registration = Registration::findOrFail($id);
            
            // Toggle the lock status
            $registration->course_unlocked = !$registration->course_unlocked;
            $registration->save();
            
            $action = $registration->course_unlocked ? 'unlocked' : 'locked';
            
            return redirect()->back()->with('success', 'Course ' . $action . ' successfully for ' . $registration->name . '!');
        } catch (\Exception $e) {
            \Log::error('Failed to toggle course lock: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update course access: ' . $e->getMessage());
        }
    }

    public function downloadFile($type, $id)
    {
        $this->checkAdmin();

        $registration = Registration::findOrFail($id);
        
        $path = $type === 'resume' ? $registration->resume_path : $registration->marksheet_path;
        
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path);
        }
        
        return back()->with('error', 'File not found');
    }

    public function updateRegistrationStatus(Request $request, $id)
    {
        $this->checkAdmin();

        $registration = Registration::findOrFail($id);
        $oldStatus = $registration->status;
        
        $validated = $request->validate([
            'status' => 'required|in:pending,contacted,verified'
        ]);

        $registration->update(['status' => $validated['status']]);

        // Send email to student
        $this->sendStatusUpdateEmail($registration, $oldStatus);

        // Send email to admin
        $this->sendAdminStatusNotification($registration, $oldStatus);

        return back()->with('success', 'Registration status updated and emails sent!');
    }

    public function updatePlacementStatus(Request $request, $id)
    {
        $this->checkAdmin();

        $placement = PlacementEnrollment::findOrFail($id);
        $oldStatus = $placement->status;
        
        $validated = $request->validate([
            'status' => 'required|in:pending,contacted,enrolled,completed'
        ]);

        $placement->update(['status' => $validated['status']]);

        // Send email to student
        $this->sendPlacementStatusEmail($placement, $oldStatus);

        // Send email to admin
        $this->sendAdminPlacementNotification($placement, $oldStatus);

        return back()->with('success', 'Placement status updated and emails sent!');
    }

    private function sendStatusUpdateEmail($registration, $oldStatus)
    {
        $data = [
            'registration' => $registration,
            'oldStatus' => $oldStatus,
            'newStatus' => $registration->status
        ];

        Mail::send('emails.status-update', $data, function ($message) use ($registration) {
            $message->to($registration->email)
                    ->subject('Registration Status Update - ORION AI');
        });
    }

    private function sendAdminStatusNotification($registration, $oldStatus)
    {
        $adminEmail = env('ADMIN_EMAIL', 'orionaiacademy@gmail.com');
        
        $data = [
            'registration' => $registration,
            'oldStatus' => $oldStatus,
            'newStatus' => $registration->status
        ];

        Mail::send('emails.admin-status-update', $data, function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                    ->subject('Registration Status Changed - ORION AI');
        });
    }

    private function sendPlacementStatusEmail($placement, $oldStatus)
    {
        $data = [
            'placement' => $placement,
            'oldStatus' => $oldStatus,
            'newStatus' => $placement->status
        ];

        Mail::send('emails.placement-status-update', $data, function ($message) use ($placement) {
            $message->to($placement->email)
                    ->subject('Placement Enrollment Status Update - ORION AI');
        });
    }

    private function sendAdminPlacementNotification($placement, $oldStatus)
    {
        $adminEmail = env('ADMIN_EMAIL', 'orionaiacademy@gmail.com');
        
        $data = [
            'placement' => $placement,
            'oldStatus' => $oldStatus,
            'newStatus' => $placement->status
        ];

        Mail::send('emails.admin-placement-status', $data, function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                    ->subject('Placement Status Changed - ORION AI');
        });
    }
}
