# PowerShell script to update PHP upload limits
# Run as Administrator

$phpIniPath = "C:\xampp\php\php.ini"

Write-Host "Updating PHP configuration..." -ForegroundColor Yellow

# Backup original file
Copy-Item $phpIniPath "$phpIniPath.backup" -Force
Write-Host "Backup created: $phpIniPath.backup" -ForegroundColor Green

# Read the file
$content = Get-Content $phpIniPath

# Update the values
$content = $content -replace '^upload_max_filesize\s*=\s*.*', 'upload_max_filesize=200M'
$content = $content -replace '^post_max_size\s*=\s*.*', 'post_max_size=200M'
$content = $content -replace '^max_execution_time\s*=\s*.*', 'max_execution_time=300'
$content = $content -replace '^memory_limit\s*=\s*.*', 'memory_limit=512M'

# Save the file
$content | Set-Content $phpIniPath

Write-Host "`nPHP configuration updated successfully!" -ForegroundColor Green
Write-Host "New settings:" -ForegroundColor Cyan
Write-Host "  upload_max_filesize = 200M" -ForegroundColor White
Write-Host "  post_max_size = 200M" -ForegroundColor White
Write-Host "  max_execution_time = 300" -ForegroundColor White
Write-Host "  memory_limit = 512M" -ForegroundColor White

Write-Host "`nPlease restart Apache in XAMPP Control Panel!" -ForegroundColor Yellow
Write-Host "Press any key to continue..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
