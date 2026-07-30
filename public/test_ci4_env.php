<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
require FCPATH . '../vendor/autoload.php';
require FCPATH . '../vendor/codeigniter4/framework/system/Config/DotEnv.php';

$dotenv = new \CodeIgniter\Config\DotEnv(realpath(__DIR__ . '/../'));
$dotenv->load();

echo "Bucket: " . env('storage.idrive_e2.bucket') . "\n";
echo "Endpoint: " . env('storage.idrive_e2.endpoint') . "\n";
