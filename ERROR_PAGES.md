# Custom Error Pages

## Overview
Professional, user-friendly error pages for common HTTP errors in the ORION AI platform.

## Error Pages Created

### 1. 403 - Access Denied (Unauthorized)
**File:** `resources/views/errors/403.blade.php`

**When it appears:**
- User tries to access admin pages without being logged in
- User is logged in but doesn't have admin privileges
- Session has expired
- Attempting to access restricted resources

**Features:**
- 🔒 Lock icon
- Clear explanation of the error
- Action buttons: "Go to Home" and "Login"
- Information box explaining why the error occurred
- Professional gradient design

**Common scenarios:**
- Accessing `/admin/dashboard` without admin login
- Accessing `/admin/courses` as a student
- Accessing admin management pages without proper permissions

---

### 2. 404 - Page Not Found
**File:** `resources/views/errors/404.blade.php`

**When it appears:**
- User navigates to a non-existent URL
- Page has been moved or deleted
- Typo in the URL

**Features:**
- 🔍 Search icon
- Friendly "page not found" message
- Action buttons: "Go to Home" and "Go Back"
- Quick links to popular pages:
  - Home
  - Browse Courses
  - Placement Series
  - Login
- Clean, modern design

---

### 3. 500 - Server Error
**File:** `resources/views/errors/500.blade.php`

**When it appears:**
- Internal server error
- Database connection issues
- PHP errors or exceptions
- Configuration problems

**Features:**
- ⚠️ Warning icon
- Reassuring message that the team is working on it
- Action buttons: "Go to Home" and "Refresh Page"
- Support contact information
- Red accent color to indicate severity

---

## Design Features

All error pages share:
- ✅ Consistent branding with ORION AI theme
- ✅ Responsive design
- ✅ Clear call-to-action buttons
- ✅ Professional gradient buttons
- ✅ Helpful information and suggestions
- ✅ Easy navigation back to working pages
- ✅ Mobile-friendly layout

## How Laravel Uses These Pages

Laravel automatically displays these custom error pages when:
1. An HTTP exception is thrown (e.g., `abort(403)`)
2. A route is not found (404)
3. An unhandled exception occurs (500)

## Testing Error Pages

### Test 403 Error:
```
Visit: http://127.0.0.1:8000/admin/dashboard (without being logged in as admin)
```

### Test 404 Error:
```
Visit: http://127.0.0.1:8000/this-page-does-not-exist
```

### Test 500 Error:
To test in development, temporarily add this to a route:
```php
Route::get('/test-500', function() {
    abort(500);
});
```

## Customization

To customize error messages or styling:
1. Edit the respective blade file in `resources/views/errors/`
2. Modify the CSS in the `@section('styles')` block
3. Update the content in the `@section('content')` block

## Additional Error Pages

You can create more custom error pages for other HTTP codes:
- `401.blade.php` - Unauthenticated
- `419.blade.php` - Page Expired (CSRF token mismatch)
- `429.blade.php` - Too Many Requests
- `503.blade.php` - Service Unavailable

## Notes

- Error pages extend the main `layouts.app` layout for consistency
- All pages include navigation back to working areas
- Support email is pulled from `.env` file (`ADMIN_EMAIL`)
- Pages are automatically used by Laravel's exception handler
- No additional configuration needed - just create the blade files
