# Unified Login System - Admin & Student

## Overview
Single login page that handles both admin users and students (registrations) with automatic role detection and routing.

## Key Features

### 1. **Unified Login Page**
- Single login URL: `/login`
- Works for both admins and students
- Automatic user type detection
- Visual tabs for user guidance
- Smart routing based on user type

### 2. **Automatic Role Detection**
The system automatically detects user type:
1. **First Check**: Admin users (User model)
   - If credentials match → Login as admin
   - Redirect to admin dashboard
2. **Second Check**: Students (Registration model)
   - If credentials match → Login as student
   - Check if course is unlocked
   - Redirect to student dashboard
3. **No Match**: Show error message

### 3. **Smart Routing**
After successful login:
- **Admins** → `/admin/dashboard`
- **Students** → `/student/dashboard`
- **Failed** → Stay on login with error

### 4. **Course Access Validation**
For students:
- Checks if `course_unlocked = true`
- If locked → Shows pending approval message
- If unlocked → Grants access to dashboard

## How It Works

### Login Flow

```
User enters email & password
        ↓
Try Admin Login (User model)
        ↓
    Success? → Admin Dashboard
        ↓ No
Try Student Login (Registration model)
        ↓
    Success? → Check course_unlocked
        ↓
    Unlocked? → Student Dashboard
        ↓ No
    Show "Pending Approval" message
        ↓
    Failed? → Show error
```

### Session Management

**Admin Login:**
- Uses Laravel Auth system
- Session managed by framework
- `Auth::user()` available

**Student Login:**
- Uses custom session storage
- Session keys:
  - `student_id`
  - `student_name`
  - `student_email`
  - `student_course_id`

### Logout Handling

**Unified Logout Route:** `/logout`

The system detects user type:
- If `student_id` in session → Student logout
- Otherwise → Admin logout

## Updated Files

### Controllers
- `app/Http/Controllers/Auth/LoginController.php` - Unified login logic
- `app/Http/Controllers/StudentAuthController.php` - Updated redirects
- `app/Http/Controllers/CourseController.php` - Updated auth check

### Views
- `resources/views/auth/login.blade.php` - New unified design with tabs

### Routes
- Removed separate `/student/login` route
- All login through `/login`
- Logout through `/logout`

## Login Page Features

### Visual Design
- **Tabs**: Student / Admin selector
- **Info Boxes**: Context-specific help text
- **Modern UI**: Gradient buttons, smooth animations
- **Responsive**: Works on all devices

### User Experience
1. User sees two tabs: "Student" and "Admin"
2. Default tab: Student (most common)
3. Click tab to see relevant info
4. Enter credentials
5. System auto-detects user type
6. Redirects to appropriate dashboard

## Usage Instructions

### For Students

1. **Register for Course**
   - Browse courses
   - Fill registration form with password
   - Submit

2. **Wait for Approval**
   - Admin unlocks course access
   - Receive notification (optional)

3. **Login**
   - Go to `/login`
   - Enter email and password
   - Automatically redirected to student dashboard

### For Admins

1. **Login**
   - Go to `/login`
   - Enter admin email and password
   - Automatically redirected to admin dashboard

2. **Unlock Student Access**
   - View registrations
   - Click "Unlock Course"
   - Student can now login and access content

## Security Features

### 1. **Password Security**
- All passwords hashed with bcrypt
- Secure comparison using `Hash::check()`
- No plain text passwords stored

### 2. **Session Security**
- Session regeneration on login
- Session invalidation on logout
- Secure session storage

### 3. **Access Control**
- Course unlock verification for students
- Admin role verification
- Protected routes with middleware

### 4. **Error Handling**
- Generic error messages (security)
- No user enumeration
- Input validation

## Error Messages

### Student Errors
- **Pending Approval**: "Your course access is pending. Please wait for admin approval."
- **Invalid Credentials**: "The provided credentials do not match our records."
- **Not Logged In**: "Please login to access your dashboard"

### Admin Errors
- **Invalid Credentials**: "The provided credentials do not match our records."

## Testing Checklist

### Student Login
- [ ] Register with password
- [ ] Try login before unlock (should fail)
- [ ] Admin unlocks course
- [ ] Login successfully
- [ ] Redirect to student dashboard
- [ ] See welcome message
- [ ] Logout works

### Admin Login
- [ ] Login with admin credentials
- [ ] Redirect to admin dashboard
- [ ] See admin panel
- [ ] Logout works

### Error Handling
- [ ] Wrong password shows error
- [ ] Wrong email shows error
- [ ] Locked course shows pending message
- [ ] Not logged in redirects to login

### Session Management
- [ ] Student session persists
- [ ] Admin session persists
- [ ] Logout clears session
- [ ] Can't access dashboard after logout

## Benefits of Unified Login

### 1. **User Experience**
- Single login URL to remember
- No confusion about which login to use
- Automatic routing to correct dashboard

### 2. **Maintenance**
- Single login page to maintain
- Consistent design and behavior
- Easier to update and improve

### 3. **Security**
- Centralized authentication logic
- Consistent security measures
- Easier to audit and test

### 4. **Flexibility**
- Easy to add more user types
- Can extend with social login
- Can add remember me, etc.

## Future Enhancements

### Possible Additions
1. **Remember Me** - Stay logged in
2. **Password Reset** - Forgot password flow
3. **Email Verification** - Verify student emails
4. **Social Login** - Google, Facebook, etc.
5. **Two-Factor Auth** - Extra security
6. **Login History** - Track login attempts

## Troubleshooting

### Can't Login as Student
- Check email is correct
- Verify password (case-sensitive)
- Ensure admin unlocked course
- Check `course_unlocked` in database

### Can't Login as Admin
- Verify admin credentials
- Check `is_admin = 1` in users table
- Ensure password is correct

### Redirects to Wrong Dashboard
- Clear browser cache
- Clear Laravel cache: `php artisan cache:clear`
- Check session configuration

### Session Not Persisting
- Check session driver in `.env`
- Verify session table exists
- Run: `php artisan session:table` then `php artisan migrate`

## Configuration

### Session Settings (.env)
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
```

### Database Tables Required
- `users` - Admin users
- `registrations` - Students
- `sessions` - Session storage
- `video_progress` - Progress tracking

## Support

The unified login system is now fully functional!

**Login URL**: `/login`
**Logout URL**: `/logout`

Works for:
- ✅ Admin users
- ✅ Students (registrations)
- ✅ Automatic role detection
- ✅ Smart routing
- ✅ Course access validation
- ✅ Secure authentication
- ✅ Session management

All users now use the same login page with automatic detection and routing!
