# ORION AI - Learning Management System

A professional learning management system built with Laravel and MySQL for offering courses and placement preparation programs.

## Features

### Student Features
- Browse and explore courses (Data Science, Machine Learning, Web Development, etc.)
- View course syllabus before enrolling
- Register for courses with detailed information form
- Upload resume and marksheet (PDF/DOCX, max 10MB)
- One free video per course, remaining videos locked until registration
- Enroll in Placement Series program (₹25,000)
- Track video completion with tick marks

### Admin Features
- View all student registrations and placement enrollments
- Download student resumes and marksheets
- Update registration status (Pending, Contacted, Verified)
- Unlock course content for specific students
- Receive email notifications for new registrations
- Comprehensive dashboard with student details

## Technology Stack

- **Backend**: Laravel 12
- **Database**: MySQL (OrionLearn)
- **Frontend**: Blade Templates with Custom CSS
- **Authentication**: Laravel Auth
- **File Storage**: Laravel Storage (public disk)

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL
- XAMPP or similar local server

### Setup Instructions

1. **Navigate to project directory**
   ```bash
   cd orion-ai
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Create MySQL database**
   - Open phpMyAdmin or MySQL CLI
   - Create database: `OrionLearn`

4. **Configure environment**
   - The `.env` file is already configured with:
     - Database: OrionLearn
     - MySQL connection
     - Admin email: admin@orionai.com

5. **Run migrations and seed data**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Create storage link**
   ```bash
   php artisan storage:link
   ```

7. **Start development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   - Website: http://localhost:8000
   - Admin Login: http://localhost:8000/login

## Default Credentials

**Admin Account:**
- Email: admin@orionai.com
- Password: admin123

## Available Courses

The system comes pre-seeded with 8 courses:
1. Data Science
2. Machine Learning
3. Web Development
4. App Development
5. Virtual & Augmented Reality
6. Power BI and Business Intelligence
7. MySQL
8. Excel

Each course includes:
- 1 free preview video
- 4 locked premium videos
- Detailed syllabus
- Course description

## Project Structure

```
orion-ai/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php
│   │   ├── CourseController.php
│   │   ├── HomeController.php
│   │   ├── PlacementController.php
│   │   ├── RegistrationController.php
│   │   └── Auth/LoginController.php
│   └── Models/
│       ├── Course.php
│       ├── Video.php
│       ├── Registration.php
│       ├── PlacementEnrollment.php
│       └── VideoProgress.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/app.blade.php
│       ├── home.blade.php
│       ├── courses/
│       ├── placement/
│       ├── registration/
│       ├── admin/
│       └── emails/
└── routes/
    └── web.php
```

## Key Routes

### Public Routes
- `/` - Home page
- `/courses` - All courses
- `/courses/{id}` - Course details
- `/courses/{id}/syllabus` - Course syllabus
- `/placement` - Placement series
- `/register/{courseId}` - Registration form

### Admin Routes (Requires Authentication)
- `/admin/dashboard` - Admin dashboard
- `/admin/registration/{id}/status` - Update status
- `/admin/registration/{id}/unlock` - Unlock course
- `/admin/download/{type}/{id}` - Download files

## Database Schema

### Tables
- **users** - Admin and user accounts
- **courses** - Course information
- **videos** - Course videos (free/locked)
- **registrations** - Student course registrations
- **placement_enrollments** - Placement program enrollments
- **video_progress** - Track completed videos

## Email Notifications

The system sends email notifications to admin for:
- New course registrations
- New placement enrollments

Configure SMTP in `.env` for production:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS=noreply@orionai.com
```

## File Upload Configuration

- **Allowed formats**: PDF, DOCX
- **Max file size**: 10MB
- **Storage location**: `storage/app/public/`
- **Required files**: Resume and Marksheet

## Professional Theme

The application uses a professional blue color scheme:
- Primary: #1e3a8a (Deep Blue)
- Secondary: #3b82f6 (Bright Blue)
- Accent: #60a5fa (Light Blue)
- Success: #10b981 (Green)

## Security Features

- Password hashing with bcrypt
- CSRF protection on all forms
- File type validation
- Admin-only routes protection
- SQL injection prevention (Eloquent ORM)

## Future Enhancements

- Payment gateway integration
- Video streaming platform integration
- Student dashboard with progress tracking
- Certificate generation
- Discussion forums
- Live classes scheduling
- Mobile app

## Support

For issues or questions, contact: admin@orionai.com

## License

This project is proprietary software for ORION AI.

---

**Developed for ORION AI Learning Platform**
