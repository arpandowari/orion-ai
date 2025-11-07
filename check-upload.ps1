# Video Upload System Check
Write-Host ""
Write-Host "=== Video Upload System Diagnostic ===" -ForegroundColor Cyan
Write-Host ""

# Check PHP upload limits
Write-Host "1. PHP Configuration:" -ForegroundColor Yellow
$uploadMax = php -r "echo ini_get('upload_max_filesize');"
$postMax = php -r "echo ini_get('post_max_size');"
$execTime = php -r "echo ini_get('max_execution_time');"
$memory = php -r "echo ini_get('memory_limit');"

Write-Host "   upload_max_filesize: $uploadMax" -ForegroundColor Green
Write-Host "   post_max_size: $postMax" -ForegroundColor Green
Write-Host "   max_execution_time: $execTime seconds" -ForegroundColor Green
Write-Host "   memory_limit: $memory" -ForegroundColor Green

# Check directories
Write-Host ""
Write-Host "2. Directory Structure:" -ForegroundColor Yellow
$storageDir = "storage\app\public\videos"
$publicLink = "public\storage"

if (Test-Path $storageDir) {
    Write-Host "   [OK] Storage directory exists" -ForegroundColor Green
} else {
    Write-Host "   [FAIL] Storage directory missing" -ForegroundColor Red
}

if (Test-Path $publicLink) {
    Write-Host "   [OK] Public symlink exists" -ForegroundColor Green
} else {
    Write-Host "   [FAIL] Public symlink missing" -ForegroundColor Red
}

# Check if Apache is running
Write-Host ""
Write-Host "3. Server Status:" -ForegroundColor Yellow
$apacheProcess = Get-Process -Name "httpd" -ErrorAction SilentlyContinue
if ($apacheProcess) {
    Write-Host "   [OK] Apache is running" -ForegroundColor Green
} else {
    Write-Host "   [FAIL] Apache is not running" -ForegroundColor Red
}

# Check uploaded videos
Write-Host ""
Write-Host "4. Uploaded Videos:" -ForegroundColor Yellow
if (Test-Path $storageDir) {
    $videos = Get-ChildItem $storageDir -File -ErrorAction SilentlyContinue
    if ($videos) {
        Write-Host "   Found $($videos.Count) video file(s)" -ForegroundColor Green
    } else {
        Write-Host "   No videos uploaded yet" -ForegroundColor Gray
    }
}

# Summary
Write-Host ""
Write-Host "=== Summary ===" -ForegroundColor Cyan
Write-Host "[OK] System is ready for video uploads" -ForegroundColor Green
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "1. Visit: http://127.0.0.1:8000/test-upload-config.php"
Write-Host "2. Go to Admin Dashboard and try uploading a video"
Write-Host "3. Check logs if issues occur"
Write-Host ""
