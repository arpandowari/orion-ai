# Video Upload Troubleshooting Guide

## Current Status
Upload is failing with "Upload failed. Please try again." message.

## Step-by-Step Fix

### 1. ⚠️ RESTART APACHE (CRITICAL!)
The PHP configuration was updated but Apache needs to be restarted:

1. Open **XAMPP Control Panel**
2. Click **Stop** next to Apache
3. Wait 3-5 seconds
4. Click **Start** next to Apache
5. Wait for Apache to fully start (green highlight)

### 2. Verify PHP Settings
After restarting Apache, visit:
```
http://127.0.0.1:8000/phpinfo-test.php
```

You should see:
- upload_max_filesize: 200M or 550M
- post_max_size: 200M or 550M

### 3. Check Browser Console
1. Open browser (F12)
2. Go to **Console** tab
3. Try uploading again
4. Look for error messages showing:
   - Status code (413, 500, etc.)
   - Actual error message
   - Response details

### 4. Common Issues & Solutions

#### Issue: Status 413 (Payload Too Large)
**Solution:** Apache needs restart or .htaccess not being read
```bash
# Check if .htaccess is working
cd orion-ai/public
type .htaccess
```

#### Issue: Status 500 (Server Error)
**Solution:** Check Laravel logs
```bash
cd orion-ai
Get-Content storage/logs/laravel.log -Tail 50
```

#### Issue: Status 0 (Network Error)
**Solution:** 
- Check if Apache is running
- Check if port 8000 is accessible
- Try restarting the dev server

#### Issue: File uploads but shows "failed"
**Solution:** Check storage permissions
```bash
cd orion-ai
php artisan storage:link
```

### 5. Test with Small File First
Try uploading a very small video (1-5MB) to isolate the issue:
- If small file works: It's a size/timeout issue
- If small file fails: It's a configuration issue

### 6. Check Storage Directory
Ensure storage directory exists and is writable:
```bash
cd orion-ai
mkdir storage\app\public\videos -Force
php artisan storage:link
```

### 7. Alternative: Use Regular Form Submission
If AJAX upload keeps failing, you can disable it temporarily:

In the edit/create form JavaScript, comment out the AJAX code and let the form submit normally.

## Current Configuration

### PHP Settings (php.ini)
- Location: `C:\xampp\php\php.ini`
- upload_max_filesize = 200M
- post_max_size = 200M
- max_execution_time = 300

### .htaccess Settings
- Location: `orion-ai/public/.htaccess`
- upload_max_filesize = 550M
- post_max_size = 550M
- max_execution_time = 600

### Laravel Validation
- Max file size: 200MB (204800 KB)
- Allowed types: mp4, mov, avi, wmv, flv, mkv

## Next Steps

1. **RESTART APACHE** (most important!)
2. Clear browser cache (Ctrl+Shift+Delete)
3. Refresh page (Ctrl+F5)
4. Open browser console (F12)
5. Try uploading a small video
6. Check console for detailed error message
7. Report the exact error message you see

## Getting More Information

When you try to upload, the browser console will now show:
- Exact HTTP status code
- Server response
- Detailed error message

This will help identify the exact problem!
