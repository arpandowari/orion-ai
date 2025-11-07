-- ============================================
-- ORION AI - Admin Content Management SQL
-- ============================================
-- Use these queries to manage courses and videos
-- All content is stored in database and fully editable
-- ============================================

-- ============================================
-- VIEW EXISTING CONTENT
-- ============================================

-- View all courses
SELECT id, name, is_active, created_at FROM courses;

-- View all videos for a specific course (change course_id)
SELECT id, title, is_free, `order`, video_url 
FROM videos 
WHERE course_id = 1 
ORDER BY `order`;

-- Count videos per course
SELECT c.name, COUNT(v.id) as video_count
FROM courses c
LEFT JOIN videos v ON c.id = v.course_id
GROUP BY c.id, c.name;

-- Find all free videos
SELECT c.name as course, v.title, v.video_url
FROM videos v
JOIN courses c ON v.course_id = c.id
WHERE v.is_free = 1;


-- ============================================
-- ADD NEW COURSE
-- ============================================

-- Example: Add a new course
INSERT INTO courses (name, description, syllabus, thumbnail, is_active, created_at, updated_at)
VALUES (
    'Python Programming',
    'Master Python from basics to advanced level',
    'Module 1: Python Basics\n- Variables and Data Types\n- Control Flow\n- Functions\n\nModule 2: OOP\n- Classes and Objects\n- Inheritance\n- Polymorphism\n\nModule 3: Advanced Topics\n- Decorators\n- Generators\n- Async Programming',
    'thumbnails/python.jpg',
    1,
    NOW(),
    NOW()
);

-- Get the ID of the course you just created
SELECT LAST_INSERT_ID();


-- ============================================
-- ADD VIDEOS TO COURSE
-- ============================================

-- Add 5 videos to a course (replace 9 with your course_id)
-- First video is FREE, others are LOCKED

INSERT INTO videos (course_id, title, description, video_url, is_free, `order`, created_at, updated_at)
VALUES 
-- Video 1 (FREE)
(9, 'Introduction to Python', 'Free preview - Learn Python basics', 'https://www.youtube.com/embed/YOUR_VIDEO_ID_1', 1, 1, NOW(), NOW()),

-- Video 2 (LOCKED)
(9, 'Python Variables and Data Types', 'Deep dive into Python variables', 'https://www.youtube.com/embed/YOUR_VIDEO_ID_2', 0, 2, NOW(), NOW()),

-- Video 3 (LOCKED)
(9, 'Python Functions', 'Master Python functions', 'https://www.youtube.com/embed/YOUR_VIDEO_ID_3', 0, 3, NOW(), NOW()),

-- Video 4 (LOCKED)
(9, 'Python OOP', 'Object-Oriented Programming in Python', 'https://www.youtube.com/embed/YOUR_VIDEO_ID_4', 0, 4, NOW(), NOW()),

-- Video 5 (LOCKED)
(9, 'Python Projects', 'Build real-world Python projects', 'https://www.youtube.com/embed/YOUR_VIDEO_ID_5', 0, 5, NOW(), NOW());


-- ============================================
-- UPDATE COURSE DETAILS
-- ============================================

-- Update course name
UPDATE courses 
SET name = 'Advanced Python Programming', updated_at = NOW()
WHERE id = 9;

-- Update course description
UPDATE courses 
SET description = 'This comprehensive course covers Python from basics to advanced topics including OOP, decorators, and async programming.', 
    updated_at = NOW()
WHERE id = 9;

-- Update course syllabus
UPDATE courses 
SET syllabus = 'Module 1: Basics\nModule 2: Intermediate\nModule 3: Advanced\nModule 4: Projects', 
    updated_at = NOW()
WHERE id = 9;

-- Update course thumbnail
UPDATE courses 
SET thumbnail = 'thumbnails/new-python-thumb.jpg', 
    updated_at = NOW()
WHERE id = 9;

-- Hide course from website
UPDATE courses 
SET is_active = 0, updated_at = NOW()
WHERE id = 9;

-- Show course on website
UPDATE courses 
SET is_active = 1, updated_at = NOW()
WHERE id = 9;


-- ============================================
-- UPDATE VIDEO DETAILS
-- ============================================

-- Update video title
UPDATE videos 
SET title = 'Python Fundamentals', updated_at = NOW()
WHERE id = 41;

-- Update video URL
UPDATE videos 
SET video_url = 'https://www.youtube.com/embed/NEW_VIDEO_ID', 
    updated_at = NOW()
WHERE id = 41;

-- Make video FREE
UPDATE videos 
SET is_free = 1, updated_at = NOW()
WHERE id = 41;

-- LOCK video
UPDATE videos 
SET is_free = 0, updated_at = NOW()
WHERE id = 41;

-- Change video order
UPDATE videos 
SET `order` = 1, updated_at = NOW()
WHERE id = 41;

-- Update video description
UPDATE videos 
SET description = 'Learn the fundamentals of Python programming', 
    updated_at = NOW()
WHERE id = 41;


-- ============================================
-- BULK OPERATIONS
-- ============================================

-- Make first video of each course FREE
UPDATE videos v
SET v.is_free = 1, v.updated_at = NOW()
WHERE v.`order` = 1;

-- Lock all videos except first one
UPDATE videos v
SET v.is_free = 0, v.updated_at = NOW()
WHERE v.`order` > 1;

-- Update all video URLs for a specific course
UPDATE videos 
SET video_url = CONCAT('https://www.youtube.com/embed/', 
    CASE `order`
        WHEN 1 THEN 'VIDEO_ID_1'
        WHEN 2 THEN 'VIDEO_ID_2'
        WHEN 3 THEN 'VIDEO_ID_3'
        WHEN 4 THEN 'VIDEO_ID_4'
        WHEN 5 THEN 'VIDEO_ID_5'
    END
),
updated_at = NOW()
WHERE course_id = 9;

-- Activate all courses
UPDATE courses 
SET is_active = 1, updated_at = NOW();

-- Deactivate specific courses
UPDATE courses 
SET is_active = 0, updated_at = NOW()
WHERE id IN (5, 6, 7);


-- ============================================
-- DELETE CONTENT
-- ============================================

-- Delete a specific video
DELETE FROM videos WHERE id = 41;

-- Delete all videos for a course
DELETE FROM videos WHERE course_id = 9;

-- Delete a course (must delete videos first due to foreign key)
DELETE FROM videos WHERE course_id = 9;
DELETE FROM courses WHERE id = 9;

-- Delete all video progress for a course (optional cleanup)
DELETE FROM video_progress 
WHERE video_id IN (SELECT id FROM videos WHERE course_id = 9);


-- ============================================
-- REORDER VIDEOS
-- ============================================

-- Swap video order (swap video 2 and video 3)
UPDATE videos SET `order` = 99, updated_at = NOW() WHERE id = 42; -- temp
UPDATE videos SET `order` = 2, updated_at = NOW() WHERE id = 43;
UPDATE videos SET `order` = 3, updated_at = NOW() WHERE id = 42;

-- Reorder all videos in a course
UPDATE videos SET `order` = 1, updated_at = NOW() WHERE id = 41;
UPDATE videos SET `order` = 2, updated_at = NOW() WHERE id = 42;
UPDATE videos SET `order` = 3, updated_at = NOW() WHERE id = 43;
UPDATE videos SET `order` = 4, updated_at = NOW() WHERE id = 44;
UPDATE videos SET `order` = 5, updated_at = NOW() WHERE id = 45;


-- ============================================
-- SEARCH AND FILTER
-- ============================================

-- Find courses by name
SELECT * FROM courses WHERE name LIKE '%Python%';

-- Find videos by title
SELECT v.*, c.name as course_name
FROM videos v
JOIN courses c ON v.course_id = c.id
WHERE v.title LIKE '%Introduction%';

-- Find all locked videos
SELECT c.name as course, v.title, v.`order`
FROM videos v
JOIN courses c ON v.course_id = c.id
WHERE v.is_free = 0
ORDER BY c.name, v.`order`;

-- Find courses with no videos
SELECT c.* 
FROM courses c
LEFT JOIN videos v ON c.id = v.course_id
WHERE v.id IS NULL;

-- Find courses with less than 5 videos
SELECT c.name, COUNT(v.id) as video_count
FROM courses c
LEFT JOIN videos v ON c.id = v.course_id
GROUP BY c.id, c.name
HAVING video_count < 5;


-- ============================================
-- STATISTICS
-- ============================================

-- Total courses
SELECT COUNT(*) as total_courses FROM courses;

-- Active courses
SELECT COUNT(*) as active_courses FROM courses WHERE is_active = 1;

-- Total videos
SELECT COUNT(*) as total_videos FROM videos;

-- Free videos
SELECT COUNT(*) as free_videos FROM videos WHERE is_free = 1;

-- Locked videos
SELECT COUNT(*) as locked_videos FROM videos WHERE is_free = 0;

-- Videos per course
SELECT c.name, COUNT(v.id) as video_count
FROM courses c
LEFT JOIN videos v ON c.id = v.course_id
GROUP BY c.id, c.name
ORDER BY video_count DESC;

-- Most popular courses (by registrations)
SELECT c.name, COUNT(r.id) as registration_count
FROM courses c
LEFT JOIN registrations r ON c.id = r.course_id
GROUP BY c.id, c.name
ORDER BY registration_count DESC;


-- ============================================
-- MAINTENANCE
-- ============================================

-- Fix video ordering (ensure sequential order)
SET @row_number = 0;
UPDATE videos 
SET `order` = (@row_number:=@row_number + 1), updated_at = NOW()
WHERE course_id = 9
ORDER BY `order`;

-- Remove duplicate videos (keep first occurrence)
DELETE v1 FROM videos v1
INNER JOIN videos v2 
WHERE v1.id > v2.id 
AND v1.course_id = v2.course_id 
AND v1.title = v2.title;

-- Update all timestamps
UPDATE courses SET updated_at = NOW();
UPDATE videos SET updated_at = NOW();


-- ============================================
-- BACKUP QUERIES
-- ============================================

-- Backup course data
SELECT * FROM courses INTO OUTFILE '/tmp/courses_backup.csv'
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n';

-- Backup video data
SELECT * FROM videos INTO OUTFILE '/tmp/videos_backup.csv'
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"'
LINES TERMINATED BY '\n';


-- ============================================
-- USEFUL VIEWS
-- ============================================

-- Create a view for course overview
CREATE OR REPLACE VIEW course_overview AS
SELECT 
    c.id,
    c.name,
    c.is_active,
    COUNT(v.id) as total_videos,
    SUM(CASE WHEN v.is_free = 1 THEN 1 ELSE 0 END) as free_videos,
    SUM(CASE WHEN v.is_free = 0 THEN 1 ELSE 0 END) as locked_videos,
    COUNT(DISTINCT r.id) as total_registrations
FROM courses c
LEFT JOIN videos v ON c.id = v.course_id
LEFT JOIN registrations r ON c.id = r.course_id
GROUP BY c.id, c.name, c.is_active;

-- Use the view
SELECT * FROM course_overview;


-- ============================================
-- NOTES FOR ADMIN
-- ============================================

/*
VIDEO URL FORMATS:

YouTube:
https://www.youtube.com/embed/VIDEO_ID

Vimeo:
https://player.vimeo.com/video/VIDEO_ID

Example:
https://www.youtube.com/embed/dQw4w9WgXcQ

IMPORTANT:
- Always use EMBED URLs, not WATCH URLs
- First video should be FREE (is_free = 1)
- Other videos should be LOCKED (is_free = 0)
- Video order should be sequential (1, 2, 3, 4, 5)
- Always update updated_at timestamp
- Test video URLs before saving
- Backup database before bulk changes
*/


-- ============================================
-- QUICK REFERENCE
-- ============================================

/*
COMMON TASKS:

1. Add new course:
   - INSERT INTO courses
   - Get LAST_INSERT_ID()
   - INSERT videos with that course_id

2. Update course:
   - UPDATE courses SET ... WHERE id = X

3. Update video:
   - UPDATE videos SET ... WHERE id = X

4. Make video free:
   - UPDATE videos SET is_free = 1 WHERE id = X

5. Lock video:
   - UPDATE videos SET is_free = 0 WHERE id = X

6. Hide course:
   - UPDATE courses SET is_active = 0 WHERE id = X

7. Show course:
   - UPDATE courses SET is_active = 1 WHERE id = X

8. Delete course:
   - DELETE FROM videos WHERE course_id = X
   - DELETE FROM courses WHERE id = X
*/
