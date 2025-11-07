# Complete Password Reset System

## Overview
A comprehensive password reset system with email OTP verification for both Students and Administrators, integrated into the unified login page.

## Features
- ✅ Email-based OTP verification
- ✅ 6-digit OTP code
- ✅ 10-minute expiration time
- ✅ One-time use OTP
- ✅ Professional email templates
- ✅ Secure password reset flow
- ✅ Integrated into unified Student/Admin login page
- ✅ Separate flows for Students and Admins
- ✅ Auto-submit on 6-digit entry

## Unified Login Page

### Location
`http://127.0.0.1:8000/login`

### Features
- **Student Tab**: Shows "Forgot Password?" link for student password reset
- **Administrator Tab**: Shows "Forgot Password?" link for admin password reset
- Links automatically switch based on selected tab

## Student Password Reset Flow

### 1. Forgot Password
- Student clicks "Forgot Password?" on Student tab
- Enters registered email address
- System sends 6-digit OTP to email

### 2. Verify OTP
- Student receives email with OTP code
- Enters the 6-digit code
- Auto-submits when 6 digits are entered
- OTP is validated and marked as used

### 3. Reset Password
- After OTP verification, student sets new password
- Password must be minimum 8 characters
- Password confirmation required
- Success message and redirect to login

### Routes
```
GET  /student/forgot-password      - Show forgot password form
POST /student/send-otp              - Send OTP to email
GET  /student/verify-otp            - Show OTP verification form
POST /student/verify-otp            - Verify OTP code
GET  /student/reset-password        - Show reset password form
POST /student/reset-password        - Update password
```

## Admin Password Reset Flow

### 1. Forgot Password
- Admin clicks "Forgot Password?" on Administrator tab
- Enters admin email address
- System verifies admin status
- Sends 6-digit OTP to admin email

### 2. Verify OTP
- Admin receives email with OTP code
- Enters the 6-digit code
- Auto-submits when 6 digits are entered
- OTP is validated and marked as used

### 3. Reset Password
- After OTP verification, admin sets new password
- Password must be minimum 8 characters
- Password confirmation required
- Notification email sent about password change
- Success message and redirect to login

### Routes
```
GET  /admin/forgot-password         - Show admin forgot password form
POST /admin/send-otp                - Send OTP to admin email
GET  /admin/verify-otp              - Show admin OTP verification form
POST /admin/verify-otp              - Verify admin OTP code
GET  /admin/reset-password          - Show admin reset password form
POST /admin/reset-password          - Update admin password
```

## Database

### password_reset_otps Table
- `id` - Primary key
- `email` - User/Admin email
- `otp` - 6-digit code
- `expires_at` - Expiration timestamp (10 minutes)
- `used` - Boolean flag
- `created_at` / `updated_at` - Timestamps

**Note:** Same table is used for both students and admins

## Security Features

1. **OTP Expiration**: Codes expire after 10 minutes
2. **One-Time Use**: OTPs are marked as used after verification
3. **Email Validation**: Only registered emails can request reset
4. **Session Protection**: Reset flow requires OTP verification
5. **Old OTP Cleanup**: Previous OTPs are deleted when new one is requested
6. **Admin Verification**: Admin reset only works for accounts with `is_admin = true`
7. **Separate Flows**: Students and admins have completely separate reset flows

## Email Templates

### Student OTP Email
- File: `resources/views/emails/student-password-reset-otp.blade.php`
- Subject: "Password Reset OTP - ORION AI"
- Features: Professional design, security warnings, expiration notice

### Admin OTP Email
- File: `resources/views/emails/admin-password-reset-otp.blade.php`
- Subject: "Admin Password Reset OTP - ORION AI"
- Features: Admin badge, enhanced security warnings, critical notice styling

### Admin Password Changed Email
- File: `resources/views/emails/admin-password-changed.blade.php`
- Subject: "Admin Password Changed - ORION AI"
- Sent automatically after successful admin password reset

## Email Configuration

Make sure your `.env` file has proper mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=orionaiacademy@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=orionaiacademy@gmail.com
MAIL_FROM_NAME="ORION AI"
```

## Testing

### Student Password Reset
1. Go to: `http://127.0.0.1:8000/login`
2. Ensure "Student" tab is selected
3. Click "Forgot Password?"
4. Enter a registered student email
5. Check email for OTP code
6. Enter OTP on verification page
7. Set new password
8. Login with new credentials

### Admin Password Reset
1. Go to: `http://127.0.0.1:8000/login`
2. Click "Administrator" tab
3. Click "Forgot Password?"
4. Enter an admin email address
5. Check email for OTP code
6. Enter OTP on verification page
7. Set new password
8. Receive password change confirmation email
9. Login with new credentials

## Files Created

### Student Password Reset:
- `app/Models/PasswordResetOtp.php`
- `database/migrations/2025_11_03_142655_create_password_reset_otps_table.php`
- `resources/views/emails/student-password-reset-otp.blade.php`
- `resources/views/student/forgot-password.blade.php`
- `resources/views/student/verify-otp.blade.php`
- `resources/views/student/reset-password.blade.php`

### Admin Password Reset:
- `app/Http/Controllers/Auth/AdminPasswordResetController.php` - Dedicated controller for admin password reset
- `resources/views/emails/admin-password-reset-otp.blade.php`
- `resources/views/admin/forgot-password.blade.php`
- `resources/views/admin/verify-otp.blade.php`
- `resources/views/admin/reset-password.blade.php`

## Files Modified

- `app/Http/Controllers/StudentAuthController.php` - Added student password reset methods
- `routes/web.php` - Added password reset routes for both students and admins
- `resources/views/auth/login.blade.php` - Added "Forgot Password?" links for both tabs

## Key Differences: Student vs Admin

| Feature | Student | Admin |
|---------|---------|-------|
| Email Template | Standard security warnings | Enhanced security, admin badge |
| Verification | Email exists in registrations | Email exists + is_admin = true |
| Post-Reset Email | No | Yes (password changed notification) |
| Route Prefix | /student/ | /admin/ |
| Session Keys | email, otp_verified | admin_email, admin_otp_verified |

## Notes

- OTPs are automatically cleaned up when new ones are requested
- The system prevents reuse of OTPs
- Session-based security ensures proper flow completion
- Professional email templates with security warnings
- Both flows are completely independent
- Same database table used for efficiency
- Auto-submit feature on OTP entry for better UX
