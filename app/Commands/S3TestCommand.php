<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class S3TestCommand extends BaseCommand
{
    protected $group       = 'Storage';
    protected $name        = 's3:test';
    protected $description = 'Test the IDrive e2 / S3 configuration.';

    public function run(array $params)
    {
        CLI::write('Testing S3 Configuration...', 'yellow');

        $key      = env('storage.idrive_e2.key');
        $secret   = env('storage.idrive_e2.secret');
        $region   = env('storage.idrive_e2.region');
        $endpoint = env('storage.idrive_e2.endpoint');
        $bucket   = env('storage.idrive_e2.bucket');

        if (!$key || !$secret || !$region || !$endpoint || !$bucket) {
            CLI::error('Configuration is incomplete in .env file!');
            CLI::write('Make sure storage.idrive_e2.key, secret, region, endpoint, and bucket are set.');
            return;
        }

        CLI::write("Endpoint : " . $endpoint);
        CLI::write("Region   : " . $region);
        CLI::write("Bucket   : " . $bucket);

        try {
            $s3 = new \App\Libraries\AwsS3Service();
            
            $fileName = 'test_cli_' . time() . '.txt';
            $localPath = WRITEPATH . 'uploads/' . $fileName;
            
            if (!is_dir(WRITEPATH . 'uploads')) {
                mkdir(WRITEPATH . 'uploads', 0777, true);
            }
            file_put_contents($localPath, 'This is a test file to check S3 upload.');
            
            CLI::write('Attempting to upload a test file...', 'yellow');
            $result = $s3->uploadFile($localPath, 'materials/' . $fileName);
            
            if ($result) {
                CLI::write('Upload Success!', 'green');
                CLI::write('Public URL: ' . $result, 'green');
                
                $sm = new \App\Libraries\StorageManager();
                $presigned = $sm->getFileUrl('materials/' . $fileName);
                CLI::write('Presigned URL: ' . $presigned, 'green');
            } else {
                CLI::error('Upload Failed!');
                if (file_exists(WRITEPATH . 'logs/s3_error.txt')) {
                    CLI::write('Error Log:', 'red');
                    CLI::write(file_get_contents(WRITEPATH . 'logs/s3_error.txt'));
                } else {
                    CLI::write('No error log found. Check your AwsS3Service.', 'red');
                }
            }
            
            if (file_exists($localPath)) {
                unlink($localPath);
            }

        } catch (\Exception $e) {
            CLI::error('Exception occurred: ' . $e->getMessage());
        }
    }
}
