<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Course;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        if (!User::where('email', 'admin@orionai.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'arpandoari@gmail.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]);
            $this->command->info('✓ Admin user created: admin@orionai.com / admin123');
        }

        // Create courses
        if (Course::count() === 0) {
            $courses = [
                [
                    'name' => 'Data Science',
                    'description' => 'Master data analysis, machine learning, and statistical modeling with Python.',
                    'syllabus' => "Module 1: Python Programming\n- Python Basics\n- Data Structures\n- NumPy & Pandas\n\nModule 2: Data Analysis\n- Data Cleaning\n- Exploratory Data Analysis\n- Data Visualization\n\nModule 3: Machine Learning\n- Supervised Learning\n- Unsupervised Learning\n- Model Evaluation\n\nModule 4: Deep Learning\n- Neural Networks\n- TensorFlow & Keras\n- Real-world Projects",
                    'is_active' => true,
                ],
                [
                    'name' => 'Machine Learning',
                    'description' => 'Learn algorithms, neural networks, and AI applications.',
                    'syllabus' => "Module 1: ML Fundamentals\n- Linear Regression\n- Logistic Regression\n- Decision Trees\n\nModule 2: Advanced ML\n- Random Forests\n- SVM\n- Ensemble Methods\n\nModule 3: Deep Learning Basics\n- Neural Networks\n- CNN\n- RNN\n\nModule 4: NLP & Computer Vision\n- Text Processing\n- Image Recognition\n- Transfer Learning",
                    'is_active' => true,
                ],
                [
                    'name' => 'Web Development',
                    'description' => 'Build modern web applications with latest technologies.',
                    'syllabus' => "Module 1: Frontend Basics\n- HTML, CSS, JavaScript\n- Responsive Design\n- Bootstrap\n\nModule 2: Frontend Frameworks\n- React.js\n- Vue.js\n- State Management\n\nModule 3: Backend Development\n- Node.js & Express\n- PHP & Laravel\n- RESTful APIs\n\nModule 4: Full Stack Projects\n- Database Design\n- Authentication\n- Deployment",
                    'is_active' => true,
                ],
                [
                    'name' => 'App Development',
                    'description' => 'Create mobile applications for iOS and Android platforms.',
                    'syllabus' => "Module 1: Mobile Basics\n- UI/UX Design\n- Mobile Architecture\n- Development Tools\n\nModule 2: React Native\n- Components\n- Navigation\n- State Management\n\nModule 3: Native Development\n- iOS with Swift\n- Android with Kotlin\n- Platform APIs\n\nModule 4: Advanced Topics\n- Push Notifications\n- Payment Integration\n- App Store Deployment",
                    'is_active' => true,
                ],
            ];

            foreach ($courses as $course) {
                Course::create($course);
            }
            
            $this->command->info('✓ Created 4 courses');
        }

        // Create sample videos for each course
        if (DB::table('videos')->count() === 0) {
            $courses = Course::all();
            
            foreach ($courses as $course) {
                // Add 5 sample videos per course
                $videos = [
                    [
                        'course_id' => $course->id,
                        'title' => 'Introduction to ' . $course->name,
                        'description' => 'Get started with the fundamentals and overview of the course.',
                        'video_url' => 'videos/sample-intro.mp4',
                        'is_free' => true,
                        'order' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'course_id' => $course->id,
                        'title' => 'Core Concepts - Part 1',
                        'description' => 'Learn the essential concepts and principles.',
                        'video_url' => 'videos/sample-lesson1.mp4',
                        'is_free' => false,
                        'order' => 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'course_id' => $course->id,
                        'title' => 'Core Concepts - Part 2',
                        'description' => 'Deep dive into advanced topics and techniques.',
                        'video_url' => 'videos/sample-lesson2.mp4',
                        'is_free' => false,
                        'order' => 3,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'course_id' => $course->id,
                        'title' => 'Practical Applications',
                        'description' => 'Apply your knowledge with real-world examples.',
                        'video_url' => 'videos/sample-practical.mp4',
                        'is_free' => false,
                        'order' => 4,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'course_id' => $course->id,
                        'title' => 'Final Project & Summary',
                        'description' => 'Complete your learning journey with a comprehensive project.',
                        'video_url' => 'videos/sample-final.mp4',
                        'is_free' => false,
                        'order' => 5,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ];

                DB::table('videos')->insert($videos);
            }
            
            $this->command->info('✓ Created 20 sample videos (5 per course)');
        }

        $this->command->info('✓ Database seeding completed successfully!');
    }
}
