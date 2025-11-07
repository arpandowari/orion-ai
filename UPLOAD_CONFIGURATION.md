# Video Upload Configuration Guide

## ✅ Configuration Updated!

The PHP upload limits have been successfully increased to 200MB.

## Current Limits
- **upload_max_filesize**: 200M ✅
- **post_max_size**: 200M ✅
- **max_execution_time**: 0 (unlimited) ✅
- **memory_limit**: 512M ✅

## How to Increase Upload Limits

### For XAMPP on Windows:

1. **Locate php.ini file**:
   - Path: `C:\xampp\php\php.ini`

2. **Edit the following settings**:
   ```ini
   upload_max_filesize = 500M
   post_max_size = 500M
   max_execution_time = 300
   max_input_time = 300
   memory_limit = 512M
   ```

3. **Restart Apache**:
   - Open XAMPP Control Panel
   - Stop Apache
   - Start Apache again

4. **Verify changes**:
   ```bash
   php -r "echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL;"
   ```

### Alternative: Use Cloud Storage

For very large video files (>100MB), consider using:
- **YouTube** (embed videos)
- **Vimeo** (embed videos)
- **AWS S3** (direct upload)
- **Google Cloud Storage**

## Current Application Settings

The application is now configured to:
- Accept files up to **40MB** (matching current PHP limits)
- Show clear error messages when files are too large
- Display upload progress
- Handle upload failures gracefully

## Recommended Settings for Production

```ini
upload_max_filesize = 500M
post_max_size = 500M
max_execution_time = 600
max_input_time = 600
memory_limit = 1024M
```

## Testing Upload Limits

After changing php.ini, test with:
```bash
cd orion-ai
php -r "echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL; echo 'post_max_size: ' . ini_get('post_max_size') . PHP_EOL;"
```
