<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Video;
use App\Models\Registration;
use App\Models\VideoProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_active', true)->get();
        return view('courses.index', compact('courses'));
    }

    public function show(Request $request, $id)
    {
        $course = Course::with('videos')->findOrFail($id);
        
        // Check if user has access to this course
        $hasAccess = false;
        $userEmail = null;
        $userId = null;
        
        // Check student guard first, then admin guard
        if (auth()->guard('student')->check()) {
            $student = auth()->guard('student')->user();
            $userEmail = $student->email;
            $userId = $student->id;
        } elseif (Auth::check()) {
            $userEmail = Auth::user()->email;
            $userId = Auth::id();
        }
        
        if ($userEmail) {
            $registration = Registration::where('course_id', $course->id)
                ->where('email', $userEmail)
                ->where('course_unlocked', true)
                ->first();
            
            $hasAccess = $registration !== null;
        }

        // Get current video (from query param or first video)
        $videoId = $request->query('video');
        $currentVideo = null;
        
        if ($videoId) {
            $currentVideo = $course->videos->where('id', $videoId)->first();
        } else {
            // Default to first free video or first video if has access
            $currentVideo = $course->videos->first();
        }

        // Get completed videos for current user
        $completedVideos = [];
        $isCompleted = false;
        if ($userId && $currentVideo) {
            $completed = VideoProgress::where('user_id', $userId)
                ->where('video_id', $currentVideo->id)
                ->where('completed', true)
                ->first();
            
            $isCompleted = $completed !== null;

            // Get all completed videos for this course
            $allCompleted = VideoProgress::where('user_id', $userId)
                ->whereIn('video_id', $course->videos->pluck('id'))
                ->where('completed', true)
                ->get();
            
            foreach ($allCompleted as $comp) {
                $completedVideos[$comp->video_id] = true;
            }
        }

        // Check if course is completed
        $courseCompleted = false;
        if ($userId && $hasAccess) {
            $totalVideos = $course->videos->count();
            $completedCount = count($completedVideos);
            $courseCompleted = $totalVideos > 0 && $completedCount === $totalVideos;
        }

        return view('courses.show', compact('course', 'currentVideo', 'hasAccess', 'completedVideos', 'isCompleted', 'courseCompleted'));
    }

    public function syllabus($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.syllabus', compact('course'));
    }

    public function completeVideo(Request $request, $videoId)
    {
        // Check if student is logged in
        if (!auth()->guard('student')->check() && !Auth::check()) {
            return redirect()->route('student.login')->with('error', 'Please login to mark videos as complete');
        }

        $video = Video::findOrFail($videoId);
        
        // Get user ID from student guard or admin guard
        $userId = auth()->guard('student')->check() 
            ? auth()->guard('student')->id() 
            : Auth::id();
        
        // Check if user has access
        $registration = Registration::where('course_id', $video->course_id)
            ->where('id', $userId)
            ->where('course_unlocked', true)
            ->first();

        if (!$registration && !$video->is_free) {
            return back()->with('error', 'You do not have access to this course');
        }

        VideoProgress::updateOrCreate(
            [
                'user_id' => $userId,
                'video_id' => $videoId
            ],
            [
                'completed' => true
            ]
        );

        return back()->with('success', 'Video marked as completed!');
    }
}
