-- ============================================
-- ORION AI - Sample Admin Content for Import
-- ============================================
-- This file adds example courses and videos
-- Run this after initial migration
-- ============================================

USE OrionLearn;

-- ============================================
-- ADD SAMPLE COURSES (Beyond the 8 seeded)
-- ============================================

-- Example Course 1: React Development
INSERT INTO courses (name, description, syllabus, thumbnail, is_active, created_at, updated_at)
VALUES (
    'React Development',
    'Master React.js and build modern web applications',
    'Module 1: React Basics\n- Components and Props\n- State and Lifecycle\n- Handling Events\n\nModule 2: Advanced React\n- Hooks (useState, useEffect)\n- Context API\n- Custom Hooks\n\nModule 3: React Router\n- Navigation\n- Dynamic Routes\n- Protected Routes\n\nModule 4: State Management\n- Redux Basics\n- Redux Toolkit\n- Async Actions',
    NULL,
    1,
    NOW(),
    NOW()
);

SET @react_course_id = LAST_INSERT_ID();

-- Add videos for React Development
INSERT INTO videos (course_id, title, description, video_url, is_free, `order`, created_at, updated_at)
VALUES 
(@react_course_id, 'Introduction to React', 'Free preview - Learn React basics', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 1, 1, NOW(), NOW()),
(@react_course_id, 'React Components', 'Deep dive into React components', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 2, NOW(), NOW()),
(@react_course_id, 'React Hooks', 'Master React Hooks', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 3, NOW(), NOW()),
(@react_course_id, 'React Router', 'Navigation in React', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 4, NOW(), NOW()),
(@react_course_id, 'React Projects', 'Build real-world projects', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 5, NOW(), NOW());


-- Example Course 2: Node.js Backend
INSERT INTO courses (name, description, syllabus, thumbnail, is_active, created_at, updated_at)
VALUES (
    'Node.js Backend Development',
    'Build scalable backend applications with Node.js and Express',
    'Module 1: Node.js Fundamentals\n- Node.js Basics\n- NPM and Modules\n- File System\n\nModule 2: Express.js\n- Routing\n- Middleware\n- Error Handling\n\nModule 3: Database Integration\n- MongoDB\n- Mongoose\n- CRUD Operations\n\nModule 4: Authentication\n- JWT\n- Passport.js\n- Security Best Practices',
    NULL,
    1,
    NOW(),
    NOW()
);

SET @node_course_id = LAST_INSERT_ID();

-- Add videos for Node.js Backend
INSERT INTO videos (course_id, title, description, video_url, is_free, `order`, created_at, updated_at)
VALUES 
(@node_course_id, 'Introduction to Node.js', 'Free preview - Node.js basics', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 1, 1, NOW(), NOW()),
(@node_course_id, 'Express.js Framework', 'Learn Express.js', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 2, NOW(), NOW()),
(@node_course_id, 'Database with MongoDB', 'MongoDB integration', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 3, NOW(), NOW()),
(@node_course_id, 'Authentication & Security', 'Secure your API', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 4, NOW(), NOW()),
(@node_course_id, 'Node.js Projects', 'Build complete backend', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 5, NOW(), NOW());


-- Example Course 3: Python for Data Analysis
INSERT INTO courses (name, description, syllabus, thumbnail, is_active, created_at, updated_at)
VALUES (
    'Python for Data Analysis',
    'Analyze data using Python, Pandas, and NumPy',
    'Module 1: Python Basics\n- Variables and Data Types\n- Control Flow\n- Functions\n\nModule 2: NumPy\n- Arrays\n- Operations\n- Broadcasting\n\nModule 3: Pandas\n- DataFrames\n- Data Cleaning\n- Data Manipulation\n\nModule 4: Visualization\n- Matplotlib\n- Seaborn\n- Plotly',
    NULL,
    1,
    NOW(),
    NOW()
);

SET @python_course_id = LAST_INSERT_ID();

-- Add videos for Python Data Analysis
INSERT INTO videos (course_id, title, description, video_url, is_free, `order`, created_at, updated_at)
VALUES 
(@python_course_id, 'Python Basics for Data Analysis', 'Free preview - Python fundamentals', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 1, 1, NOW(), NOW()),
(@python_course_id, 'NumPy Essentials', 'Master NumPy arrays', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 2, NOW(), NOW()),
(@python_course_id, 'Pandas DataFrames', 'Work with Pandas', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 3, NOW(), NOW()),
(@python_course_id, 'Data Visualization', 'Create stunning visualizations', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 4, NOW(), NOW()),
(@python_course_id, 'Data Analysis Projects', 'Real-world data analysis', 'https://www.youtube.com/embed/dQw4w9WgXcQ', 0, 5, NOW(), NOW());


-- ============================================
-- VERIFICATION QUERIES
-- ============================================

-- Check total courses
SELECT COUNT(*) as total_courses FROM courses;

-- Check total videos
SELECT COUNT(*) as total_videos FROM videos;

-- Check courses with video count
SELECT c.name, COUNT(v.id) as video_count
FROM courses c
LEFT JOIN videos v ON c.id = v.course_id
GROUP BY c.id, c.name
ORDER BY c.id;

-- Check free videos
SELECT c.name as course, v.title
FROM videos v
JOIN courses c ON v.course_id = c.id
WHERE v.is_free = 1
ORDER BY c.name;

-- ============================================
-- SUCCESS MESSAGE
-- ============================================

SELECT 'Sample admin content imported successfully!' as message,
       (SELECT COUNT(*) FROM courses) as total_courses,
       (SELECT COUNT(*) FROM videos) as total_videos;
