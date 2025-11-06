<?php
echo "PHP Upload Configuration Test\n\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "max_execution_time: " . ini_get('max_execution_time') . "\n";
echo "max_input_time: " . ini_get('max_input_time') . "\n";
echo "memory_limit: " . ini_get('memory_limit') . "\n";
echo "\nMax upload size: " . min(
    ini_get('upload_max_filesize'),
    ini_get('post_max_size')
) . "\n";
