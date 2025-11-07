# Student Password Reset System

## Overview
A secure password reset system for students using email OTP (One-Time Password) verification, integrated into the unified login page.

## Features
- ✅ Email-based OTP verification
- ✅ 6-digit OTP code
- ✅ 10-minute expiration time
- ✅ One-time use OTP
- ✅ Professional email template
- ✅ Secure password reset flow
- ✅ Integrated into unified Student/Admin login page
- ✅ Only visible for Student tab

## User Flow

### 1. Forgot Password
- Student clicks "Forgot Password?" on login page
- Enters their registered email address
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

## Routes

```php
GET  /student/forgot-password      - Show forgot password form
POST /student/send-otp              - Send OTP to email
GET  /student/verify-otp            - Show OTP verification form
POST /student/verify-otp            - Verify OTP code
GET  /student/reset-password        - Show reset password form
POST /student/reset-password        - Update password
```

## Database

### password_reset_otps Table
- `id` - Primary key
- `email` - Student email
- `otp` - 6-digit code
- `expires_at` - Expiration timestamp (10 minutes)
- `used` - Boolean flag
- `created_at` / `updated_at` - Timestamps

## Security Features

1. **OTP Expiration**: Codes expire after 10 minutes
2. **One-Time Use**: OTPs are marked as used after verification
3. **Email Validation**: Only registered emails can request reset
4. **Session Protection**: Reset flow requires OTP verification
5. **Old OTP Cleanup**: Previous OTPs are deleted when new one is requested

## Email Configuration

Make sure your `.env` file has proper mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="ORION AI"
```

## Testing

1. Go to: `http://127.0.0.1:8000/login`
2. Make sure "Student" tab is selected
3. Click "Forgot Password?" link (below password field)
4. Enter a registered student email
5. Check email for OTP code
6. Enter OTP on verification page
7. Set new password
8. Login with new credentials

**Note:** The "Forgot Password?" link only appears when the Student tab is active. It's hidden for Administrator login.

## Files Created/Modified

### New Files:
- `app/Models/PasswordResetOtp.php`
- `database/migrations/2025_11_03_142655_create_password_reset_otps_table.php`
- `resources/views/emails/student-password-reset-otp.blade.php`
- `resources/views/student/forgot-password.blade.php`
- `resources/views/student/verify-otp.blade.php`
- `resources/views/student/reset-password.blade.php`

### Modified Files:
- `app/Http/Controllers/StudentAuthController.php` - Added password reset methods
- `routes/web.php` - Added password reset routes
- `resources/views/auth/login.blade.php` - Added "Forgot Password?" link (unified login page)

## Notes

- OTPs are automatically cleaned up when new ones are requested
- The system prevents reuse of OTPs
- Session-based security ensures proper flow completion
- Professional email template with security warnings
