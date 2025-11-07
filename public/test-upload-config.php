<?php
// Test Upload Configuration
echo "<h1>PHP Upload Configuration Test</h1>";
echo "<style>body { font-family: Arial; padding: 20px; } .good { color: green; } .bad { color: red; } table { border-collapse: collapse; } td { padding: 8px; border: 1px solid #ddd; }</style>";

echo "<h2>Current PHP Settings:</h2>";
echo "<table>";
echo "<tr><td><strong>upload_max_filesize</strong></td><td>" . ini_get('upload_max_filesize') . "</td></tr>";
echo "<tr><td><strong>post_max_size</strong></td><td>" . ini_get('post_max_size') . "</td></tr>";
echo "<tr><td><strong>max_execution_time</strong></td><td>" . ini_get('max_execution_time') . " seconds</td></tr>";
echo "<tr><td><strong>max_input_time</strong></td><td>" . ini_get('max_input_time') . " seconds</td></tr>";
echo "<tr><td><strong>memory_limit</strong></td><td>" . ini_get('memory_limit') . "</td></tr>";
echo "</table>";

echo "<h2>Storage Directory Check:</h2>";
$storageDir = __DIR__ . '/../storage/app/public/videos';
$publicLink = __DIR__ . '/storage/videos';

echo "<table>";
echo "<tr><td><strong>Storage Directory</strong></td><td>" . $storageDir . "</td><td class='" . (is_dir($storageDir) ? "good'>✓ Exists" : "bad'>✗ Missing") . "</td></tr>";
echo "<tr><td><strong>Storage Writable</strong></td><td>" . $storageDir . "</td><td class='" . (is_writable($storageDir) ? "good'>✓ Writable" : "bad'>✗ Not Writable") . "</td></tr>";
echo "<tr><td><strong>Public Symlink</strong></td><td>" . $publicLink . "</td><td class='" . (is_link($publicLink) || is_dir($publicLink) ? "good'>✓ Exists" : "bad'>✗ Missing") . "</td></tr>";
echo "</table>";

echo "<h2>Recommendations:</h2>";
$uploadMax = ini_get('upload_max_filesize');
$postMax = ini_get('post_max_size');

if (strpos($uploadMax, 'M') !== false) {
    $uploadMaxMB = (int)$uploadMax;
} else {
    $uploadMaxMB = 0;
}

if ($uploadMaxMB < 200) {
    echo "<p class='bad'>⚠ upload_max_filesize is less than 200M. Increase it in php.ini</p>";
} else {
    echo "<p class='good'>✓ upload_max_filesize is adequate</p>";
}

if (!is_writable($storageDir)) {
    echo "<p class='bad'>⚠ Storage directory is not writable. Check permissions.</p>";
} else {
    echo "<p class='good'>✓ Storage directory is writable</p>";
}

echo "<hr>";
echo "<p><a href='/'>← Back to Home</a></p>";
?>
