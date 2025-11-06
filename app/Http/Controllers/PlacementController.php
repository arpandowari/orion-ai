<?php

namespace App\Http\Controllers;

use App\Models\PlacementEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PlacementController extends Controller
{
    public function index()
    {
        return view('placement.index');
    }

    public function syllabus()
    {
        return view('placement.syllabus');
    }

    public function enroll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:placement_enrollments,email',
            'phone' => 'required|string|max:15'
        ], [
            'email.unique' => 'This email has already been enrolled in the placement program. Each email can only be used once.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $enrollment = PlacementEnrollment::create([
            'email' => $request->email,
            'phone' => $request->phone,
            'amount' => 25000
        ]);

        // Send email to admin
        $this->sendAdminNotification($enrollment);

        return redirect()->route('placement.success')->with('success', 'Thank you for enrolling! Our team will contact you shortly.');
    }

    private function sendAdminNotification($enrollment)
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@orionai.com');
        
        Mail::send('emails.placement-enrollment', ['enrollment' => $enrollment], function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                    ->subject('New Placement Series Enrollment');
        });
    }

    public function success()
    {
        return view('placement.success');
    }
}
