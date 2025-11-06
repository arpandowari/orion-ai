<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('registration.create', compact('course'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:registrations,email',
            'password' => 'required|string|min:8|confirmed',
            'cgpa' => 'nullable|numeric|min:0|max:10',
            'education_details' => 'nullable|string',
            'internship_company_1' => 'nullable|string',
            'internship_certificate_1' => 'nullable|string',
            'internship_stipend_1' => 'nullable|string',
            'internship_company_2' => 'nullable|string',
            'internship_certificate_2' => 'nullable|string',
            'internship_stipend_2' => 'nullable|string',
            'internship_company_3' => 'nullable|string',
            'internship_certificate_3' => 'nullable|string',
            'internship_stipend_3' => 'nullable|string',
            'extracurricular_activities' => 'nullable|string',
            'goal' => 'nullable|string',
            'suitable_role' => 'nullable|string',
            'expected_ctc' => 'nullable|numeric',
            'resume' => 'required|file|mimes:pdf,docx|max:10240',
            'marksheet' => 'required|file|mimes:pdf,docx|max:10240'
        ], [
            'email.unique' => 'This email has already been registered for a course. Each email can only be used once.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle file uploads
        $resumePath = $request->file('resume')->store('resumes', 'public');
        $marksheetPath = $request->file('marksheet')->store('marksheets', 'public');

        // Prepare internship data
        $internships = [];
        for ($i = 1; $i <= 3; $i++) {
            if ($request->input("internship_company_$i")) {
                $internships[] = [
                    'company' => $request->input("internship_company_$i"),
                    'certificate' => $request->input("internship_certificate_$i"),
                    'stipend' => $request->input("internship_stipend_$i")
                ];
            }
        }

        $registration = Registration::create([
            'course_id' => $request->course_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'cgpa' => $request->cgpa,
            'education_details' => $request->education_details,
            'internship_experience' => $internships,
            'extracurricular_activities' => $request->extracurricular_activities,
            'goal' => $request->goal,
            'suitable_role' => $request->suitable_role,
            'expected_ctc' => $request->expected_ctc,
            'resume_path' => $resumePath,
            'marksheet_path' => $marksheetPath
        ]);

        // Send email to admin
        $this->sendAdminNotification($registration);

        return redirect()->route('registration.success')->with('success', 'Thank you for registering. Our team will contact you shortly.');
    }

    private function sendAdminNotification($registration)
    {
        $adminEmail = env('ADMIN_EMAIL', 'admin@orionai.com');
        
        Mail::send('emails.registration', ['registration' => $registration], function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                    ->subject('New Course Registration');
        });
    }

    public function success()
    {
        return view('registration.success');
    }
}
