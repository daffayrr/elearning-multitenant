<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
chdir(__DIR__);
require 'app/Config/Paths.php';
$paths = new \Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . '/bootstrap.php';

$s3 = new \App\Libraries\AwsS3Service();
file_put_contents(WRITEPATH . 'test.txt', 'hello s3');
$result = $s3->uploadFile(WRITEPATH . 'test.txt', 'test.txt');
if ($result) {
    echo "Success: " . $result;
} else {
    echo "Failed. Check writable/logs/s3_error.txt\n";
    if (file_exists(WRITEPATH . 'logs/s3_error.txt')) {
        echo file_get_contents(WRITEPATH . 'logs/s3_error.txt');
    }
}
