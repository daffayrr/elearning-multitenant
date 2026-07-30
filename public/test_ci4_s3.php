<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
chdir(FCPATH);
require FCPATH . '../app/Config/Paths.php';
$paths = new \Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . '/Boot.php';
\CodeIgniter\Boot::bootSpark($paths);

// This will load the environment
$s3 = new \App\Libraries\AwsS3Service();
$fileName = 'test_controller_' . time() . '.txt';
file_put_contents(WRITEPATH . 'uploads/' . $fileName, 'Hello from CI4 spark test!');

$result = $s3->uploadFile(WRITEPATH . 'uploads/' . $fileName, 'materials/' . $fileName);

if ($result) {
    echo "Success: " . $result . "\n";
} else {
    echo "Failed. Error log: ";
    if (file_exists(WRITEPATH . 'logs/s3_error.txt')) {
        echo file_get_contents(WRITEPATH . 'logs/s3_error.txt');
    } else {
        echo "No error log found.\n";
    }
}
