<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Video;

class AdminContentExamplesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example Course 1: React Development
        $reactCourse = Course::create([
            'name' => 'React Development',
            'description' => 'Master React.js and build modern web applications',
            'syllabus' => "Module 1: React Basics\n- Components and Props\n- State and Lifecycle\n- Handling Events\n\nModule 2: Advanced React\n- Hooks (useState, useEffect)\n- Context API\n- Custom Hooks\n\nModule 3: React Router\n- Navigation\n- Dynamic Routes\n- Protected Routes\n\nModule 4: State Management\n- Redux Basics\n- Redux Toolkit\n- Async Actions",
            'is_active' => true
        ]);

        // Add videos for React Development
        $reactVideos = [
            ['title' => 'Introduction to React', 'description' => 'Free preview - Learn React basics', 'is_free' => true, 'order' => 1],
            ['title' => 'React Components', 'description' => 'Deep dive into React components', 'is_free' => false, 'order' => 2],
            ['title' => 'React Hooks', 'description' => 'Master React Hooks', 'is_free' => false, 'order' => 3],
            ['title' => 'React Router', 'description' => 'Navigation in React', 'is_free' => false, 'order' => 4],
            ['title' => 'React Projects', 'description' => 'Build real-world projects', 'is_free' => false, 'order' => 5],
        ];

        foreach ($reactVideos as $video) {
            $reactCourse->videos()->create([
                'title' => $video['title'],
                'description' => $video['description'],
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_free' => $video['is_free'],
                'order' => $video['order']
            ]);
        }

        // Example Course 2: Node.js Backend
        $nodeCourse = Course::create([
            'name' => 'Node.js Backend Development',
            'description' => 'Build scalable backend applications with Node.js and Express',
            'syllabus' => "Module 1: Node.js Fundamentals\n- Node.js Basics\n- NPM and Modules\n- File System\n\nModule 2: Express.js\n- Routing\n- Middleware\n- Error Handling\n\nModule 3: Database Integration\n- MongoDB\n- Mongoose\n- CRUD Operations\n\nModule 4: Authentication\n- JWT\n- Passport.js\n- Security Best Practices",
            'is_active' => true
        ]);

        // Add videos for Node.js Backend
        $nodeVideos = [
            ['title' => 'Introduction to Node.js', 'description' => 'Free preview - Node.js basics', 'is_free' => true, 'order' => 1],
            ['title' => 'Express.js Framework', 'description' => 'Learn Express.js', 'is_free' => false, 'order' => 2],
            ['title' => 'Database with MongoDB', 'description' => 'MongoDB integration', 'is_free' => false, 'order' => 3],
            ['title' => 'Authentication & Security', 'description' => 'Secure your API', 'is_free' => false, 'order' => 4],
            ['title' => 'Node.js Projects', 'description' => 'Build complete backend', 'is_free' => false, 'order' => 5],
        ];

        foreach ($nodeVideos as $video) {
            $nodeCourse->videos()->create([
                'title' => $video['title'],
                'description' => $video['description'],
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_free' => $video['is_free'],
                'order' => $video['order']
            ]);
        }

        // Example Course 3: Python for Data Analysis
        $pythonCourse = Course::create([
            'name' => 'Python for Data Analysis',
            'description' => 'Analyze data using Python, Pandas, and NumPy',
            'syllabus' => "Module 1: Python Basics\n- Variables and Data Types\n- Control Flow\n- Functions\n\nModule 2: NumPy\n- Arrays\n- Operations\n- Broadcasting\n\nModule 3: Pandas\n- DataFrames\n- Data Cleaning\n- Data Manipulation\n\nModule 4: Visualization\n- Matplotlib\n- Seaborn\n- Plotly",
            'is_active' => true
        ]);

        // Add videos for Python Data Analysis
        $pythonVideos = [
            ['title' => 'Python Basics for Data Analysis', 'description' => 'Free preview - Python fundamentals', 'is_free' => true, 'order' => 1],
            ['title' => 'NumPy Essentials', 'description' => 'Master NumPy arrays', 'is_free' => false, 'order' => 2],
            ['title' => 'Pandas DataFrames', 'description' => 'Work with Pandas', 'is_free' => false, 'order' => 3],
            ['title' => 'Data Visualization', 'description' => 'Create stunning visualizations', 'is_free' => false, 'order' => 4],
            ['title' => 'Data Analysis Projects', 'description' => 'Real-world data analysis', 'is_free' => false, 'order' => 5],
        ];

        foreach ($pythonVideos as $video) {
            $pythonCourse->videos()->create([
                'title' => $video['title'],
                'description' => $video['description'],
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_free' => $video['is_free'],
                'order' => $video['order']
            ]);
        }

        $this->command->info('✅ Admin content examples seeded successfully!');
        $this->command->info('📊 Total courses: ' . Course::count());
        $this->command->info('🎬 Total videos: ' . Video::count());
    }
}
