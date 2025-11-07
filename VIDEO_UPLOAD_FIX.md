# Video Upload Fix - Complete Guide

## ✅ What Was Fixed

I've updated the video upload system to properly save files and paths. Here's what changed:

### 1. Enhanced Error Logging
- Added detailed logging to track file upload process
- Logs show exactly where files are saved
- Easier to debug if issues occur

### 2. Directory Creation
- Automatically creates `storage/app/public/videos` if missing
- Ensures directory exists before saving files

### 3. File Verification
- Verifies file was actually saved after upload
- Throws clear error if save fails

### 4. Better Error Messages
- More descriptive error messages
- Includes full error trace in logs
- Returns user input on error (no data loss)

### 5. Increased Upload Limit
- Changed from 200MB to 500MB max file size
- Matches your server configuration

## 🔧 How to Test

### Step 1: Check Configuration
Visit this URL in your browser:
```
http://127.0.0.1:8000/test-upload-config.php
```

This will show:
- Current PHP upload limits
- Storage directory status
- Whether directories are writable

### Step 2: Try Uploading a Video

1. Go to Admin Dashboard
2. Click "Add Video"
3. Fill in the form:
   - Select a course
   - Enter title
   - Upload a video file (start with a small one, like 5-10MB)
   - Set order number
4. Click "Add Video"

### Step 3: Check the Logs

If upload fails, check the Laravel log:
```bash
Get-Content storage\logs\laravel.log -Tail 50
```

Look for entries like:
- "Video file stored successfully" ✓
- "Video record created" ✓
- "Video upload failed" ✗

## 📁 Where Files Are Stored

### Physical Location
```
C:\xampp\htdocs\OrionLearn\orion-ai\storage\app\public\videos\
```

### Database Path
```
videos/filename.mp4
```

### Public URL
```
http://127.0.0.1:8000/storage/videos/filename.mp4
```

## 🐛 Troubleshooting

### Issue: "File was not saved to storage"

**Solution:**
```bash
# Check if directory exists and is writable
Test-Path storage\app\public\videos
# If false, create it:
mkdir storage\app\public\videos -Force
```

### Issue: "Upload failed. Please try again."

**Check these:**

1. **Apache is running**
   - Open XAMPP Control Panel
   - Ensure Apache is green/running

2. **PHP limits are correct**
   - Visit: http://127.0.0.1:8000/test-upload-config.php
   - Should show 200M or higher

3. **Storage link exists**
   ```bash
   php artisan storage:link
   ```

4. **Check Laravel logs**
   ```bash
   Get-Content storage\logs\laravel.log -Tail 50
   ```

### Issue: Video uploads but doesn't play

**Solution:**
1. Check if file exists:
   ```bash
   Test-Path storage\app\public\videos\your-video.mp4
   ```

2. Check if accessible via URL:
   ```
   http://127.0.0.1:8000/storage/videos/your-video.mp4
   ```

3. Verify storage link:
   ```bash
   Test-Path public\storage
   ```

### Issue: File too large error

**Solution:**

1. **Edit php.ini** (C:\xampp\php\php.ini):
   ```ini
   upload_max_filesize = 500M
   post_max_size = 500M
   max_execution_time = 600
   memory_limit = 1024M
   ```

2. **Restart Apache** (CRITICAL!):
   - Stop Apache in XAMPP
   - Wait 5 seconds
   - Start Apache again

3. **Verify changes**:
   ```bash
   php -r "echo ini_get('upload_max_filesize');"
   ```

## 📊 Testing Checklist

- [ ] Configuration test page shows all green checkmarks
- [ ] Can upload small video (5-10MB)
- [ ] Can upload medium video (50-100MB)
- [ ] Can upload large video (200MB+)
- [ ] Video appears in admin dashboard
- [ ] Video plays when clicked
- [ ] Video path is saved in database
- [ ] File exists in storage/app/public/videos/

## 🎯 Quick Test Commands

```bash
# Check PHP upload limit
php -r "echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL;"

# Check if storage directory exists
Test-Path storage\app\public\videos

# Check if storage link exists
Test-Path public\storage

# View recent logs
Get-Content storage\logs\laravel.log -Tail 30

# List uploaded videos
dir storage\app\public\videos
```

## 💡 Tips

1. **Start Small**: Test with a 5MB video first
2. **Check Logs**: Always check Laravel logs after failed upload
3. **Restart Apache**: After changing php.ini, always restart Apache
4. **Use Test Page**: The test-upload-config.php page is your friend
5. **Browser Console**: Open F12 and check Console tab for JavaScript errors

## 🚀 What's New in the Code

### AdminCourseController.php

**storeVideo() method:**
- ✓ Creates videos directory if missing
- ✓ Verifies file was saved
- ✓ Logs detailed information
- ✓ Better error handling
- ✓ Increased to 500MB limit

**updateVideo() method:**
- ✓ Same improvements as storeVideo
- ✓ Deletes old video when replacing
- ✓ Logs old file deletion

## 📝 Next Steps

1. Visit the test configuration page
2. Try uploading a small test video
3. Check if it appears in the dashboard
4. Try playing the video
5. If successful, try a larger file

If you encounter any issues, check the Laravel logs first - they now contain detailed information about what went wrong!

## 🔗 Related Files

- Controller: `app/Http/Controllers/AdminCourseController.php`
- Model: `app/Models/Video.php`
- Config: `config/filesystems.php`
- Test Page: `public/test-upload-config.php`
- Logs: `storage/logs/laravel.log`
