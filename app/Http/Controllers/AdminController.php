<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\PlacementEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $registrations = Registration::with('course')->latest()->get();
        $placements = PlacementEnrollment::latest()->get();
        
        return view('admin.dashboard', compact('registrations', 'placements'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $registration = Registration::findOrFail($id);
        $registration->update(['status' => $request->status]);
        
        return back()->with('success', 'Status updated successfully');
    }

    public function unlockCourse($id)
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $registration = Registration::findOrFail($id);
        $registration->update(['course_unlocked' => true]);
        
        return back()->with('success', 'Course unlocked for student');
    }

    public function downloadFile($type, $id)
    {
        // Check if user is admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $registration = Registration::findOrFail($id);
        
        $path = $type === 'resume' ? $registration->resume_path : $registration->marksheet_path;
        
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->download($path);
        }
        
        return back()->with('error', 'File not found');
    }
}
