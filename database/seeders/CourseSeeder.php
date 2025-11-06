<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Video;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'name' => 'Data Science',
                'description' => 'Master data analysis, machine learning, and statistical modeling',
                'syllabus' => "Module 1: Python Programming\n- Python Basics\n- NumPy and Pandas\n- Data Visualization\n\nModule 2: Statistics\n- Descriptive Statistics\n- Probability\n- Hypothesis Testing\n\nModule 3: Machine Learning\n- Supervised Learning\n- Unsupervised Learning\n- Model Evaluation"
            ],
            [
                'name' => 'Machine Learning',
                'description' => 'Learn algorithms, neural networks, and AI applications',
                'syllabus' => "Module 1: ML Fundamentals\n- Linear Regression\n- Logistic Regression\n- Decision Trees\n\nModule 2: Deep Learning\n- Neural Networks\n- CNNs\n- RNNs\n\nModule 3: Advanced Topics\n- NLP\n- Computer Vision\n- Reinforcement Learning"
            ],
            [
                'name' => 'Web Development',
                'description' => 'Build modern web applications with latest technologies',
                'syllabus' => "Module 1: Frontend\n- HTML, CSS, JavaScript\n- React.js\n- Responsive Design\n\nModule 2: Backend\n- Node.js\n- Express.js\n- RESTful APIs\n\nModule 3: Database\n- MongoDB\n- MySQL\n- Authentication"
            ],
            [
                'name' => 'App Development',
                'description' => 'Create mobile applications for iOS and Android',
                'syllabus' => "Module 1: Mobile Basics\n- UI/UX Design\n- React Native\n- Flutter\n\nModule 2: Advanced Features\n- Navigation\n- State Management\n- API Integration\n\nModule 3: Deployment\n- App Store\n- Play Store\n- Testing"
            ],
            [
                'name' => 'Virtual & Augmented Reality',
                'description' => 'Explore immersive technologies and 3D development',
                'syllabus' => "Module 1: VR Fundamentals\n- Unity 3D\n- VR Hardware\n- Interaction Design\n\nModule 2: AR Development\n- ARCore/ARKit\n- Spatial Mapping\n- Object Recognition\n\nModule 3: Projects\n- VR Games\n- AR Applications\n- Mixed Reality"
            ],
            [
                'name' => 'Power BI and Business Intelligence',
                'description' => 'Transform data into actionable business insights',
                'syllabus' => "Module 1: Power BI Basics\n- Data Import\n- Data Modeling\n- DAX Functions\n\nModule 2: Visualizations\n- Charts and Graphs\n- Dashboards\n- Reports\n\nModule 3: Advanced BI\n- Data Warehousing\n- ETL Processes\n- Analytics"
            ],
            [
                'name' => 'MySQL',
                'description' => 'Master database design and SQL queries',
                'syllabus' => "Module 1: SQL Basics\n- SELECT Queries\n- Joins\n- Subqueries\n\nModule 2: Database Design\n- Normalization\n- Indexes\n- Constraints\n\nModule 3: Advanced SQL\n- Stored Procedures\n- Triggers\n- Optimization"
            ],
            [
                'name' => 'Excel',
                'description' => 'Advanced Excel for data analysis and automation',
                'syllabus' => "Module 1: Excel Fundamentals\n- Formulas and Functions\n- Pivot Tables\n- Charts\n\nModule 2: Data Analysis\n- VLOOKUP/XLOOKUP\n- Conditional Formatting\n- Data Validation\n\nModule 3: Automation\n- Macros\n- VBA Programming\n- Power Query"
            ]
        ];

        foreach ($courses as $courseData) {
            $course = Course::create($courseData);
            
            // Create sample videos for each course
            Video::create([
                'course_id' => $course->id,
                'title' => 'Introduction to ' . $course->name,
                'description' => 'Free preview video',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_free' => true,
                'order' => 1
            ]);

            for ($i = 2; $i <= 5; $i++) {
                Video::create([
                    'course_id' => $course->id,
                    'title' => $course->name . ' - Lesson ' . $i,
                    'description' => 'Premium content',
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'is_free' => false,
                    'order' => $i
                ]);
            }
        }
    }
}
