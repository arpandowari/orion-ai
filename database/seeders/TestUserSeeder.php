<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Registration;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test student user
        $user = User::create([
            'name' => 'Test Student',
            'email' => 'student@test.com',
            'password' => Hash::make('student123'),
            'is_admin' => false
        ]);

        // Create a registration for Data Science course with unlocked access
        $course = Course::where('name', 'Data Science')->first();
        
        if ($course) {
            Registration::create([
                'course_id' => $course->id,
                'name' => 'Test Student',
                'email' => 'student@test.com',
                'cgpa' => 8.5,
                'education_details' => 'B.Tech Computer Science',
                'internship_experience' => [
                    [
                        'company' => 'Tech Corp',
                        'certificate' => 'Certificate Link',
                        'stipend' => '₹20,000'
                    ]
                ],
                'extracurricular_activities' => 'Sports, Music',
                'goal' => 'Become a Data Scientist',
                'suitable_role' => 'Data Analyst',
                'expected_ctc' => 10.0,
                'resume_path' => 'resumes/test-resume.pdf',
                'marksheet_path' => 'marksheets/test-marksheet.pdf',
                'status' => 'verified',
                'course_unlocked' => true // This unlocks all videos for this student
            ]);
        }
    }
}
