# How to Add Videos - Simple Path Method

## Overview
Instead of uploading videos through the web form, you now:
1. Copy video files directly to the server folder
2. Enter just the filename in the form
3. System stores only the path in database

This avoids all upload size limits and is much faster!

## Step-by-Step Guide

### Method 1: Copy Files Directly (Recommended)

1. **Locate the videos folder:**
   ```
   C:\xampp\htdocs\OrionLearn\orion-ai\storage\app\public\videos\
   ```

2. **Copy your video file** to this folder
   - Example: Copy `my-lesson.mp4` to the videos folder

3. **Go to Admin Dashboard** → Add Video or Edit Video

4. **Enter the filename** in "Video File Path" field:
   - Just filename: `my-lesson.mp4`
   - Or with subfolder: `course1/lesson1.mp4`

5. **Fill other fields** (Course, Title, Description, Order)

6. **Click Submit** - Done! ✅

### Method 2: Organize by Course (Optional)

Create subfolders for better organization:

```
storage/app/public/videos/
├── python-course/
│   ├── lesson1.mp4
│   ├── lesson2.mp4
│   └── lesson3.mp4
├── javascript-course/
│   ├── intro.mp4
│   └── advanced.mp4
└── data-science/
    └── pandas-basics.mp4
```

Then enter paths like:
- `python-course/lesson1.mp4`
- `javascript-course/intro.mp4`

## Examples

### Example 1: Simple Filename
**File location:** `storage/app/public/videos/intro-to-python.mp4`
**Enter in form:** `intro-to-python.mp4`
**Stored in DB:** `videos/intro-to-python.mp4`

### Example 2: With Subfolder
**File location:** `storage/app/public/videos/python/lesson1.mp4`
**Enter in form:** `python/lesson1.mp4`
**Stored in DB:** `videos/python/lesson1.mp4`

### Example 3: Already includes "videos/"
**Enter in form:** `videos/my-video.mp4`
**Stored in DB:** `videos/my-video.mp4` (not duplicated)

## Benefits

✅ **No upload limits** - Add videos of any size
✅ **Much faster** - No waiting for uploads
✅ **Bulk add** - Copy multiple files at once
✅ **Better organization** - Use folders to organize
✅ **No timeouts** - No server timeout issues
✅ **Easy backup** - Just copy the videos folder

## Accessing Videos

Videos are accessible at:
```
http://127.0.0.1:8000/storage/videos/your-video.mp4
```

The system automatically creates the correct URL when displaying videos.

## Tips

💡 **Use descriptive filenames:**
- Good: `python-basics-lesson1.mp4`
- Bad: `vid1.mp4`

💡 **Keep filenames simple:**
- Use lowercase
- Use hyphens instead of spaces
- Avoid special characters

💡 **Organize by course:**
- Create a folder for each course
- Makes management easier

💡 **Check file exists:**
- Make sure the file is actually in the folder
- Check spelling of filename

## Troubleshooting

**Video not playing?**
- Check if file exists in `storage/app/public/videos/`
- Verify filename spelling matches exactly
- Make sure storage link exists: `php artisan storage:link`

**Path not working?**
- Don't include full path, just filename or relative path
- System automatically adds `videos/` prefix
- Example: Use `lesson1.mp4` not `C:\xampp\...`

## Quick Reference

**Videos folder location:**
```
orion-ai/storage/app/public/videos/
```

**Form field:**
- Enter: `filename.mp4` or `subfolder/filename.mp4`
- System stores: `videos/filename.mp4`

**Public URL:**
```
http://127.0.0.1:8000/storage/videos/filename.mp4
```

That's it! Much simpler than uploading through the web form! 🎉
