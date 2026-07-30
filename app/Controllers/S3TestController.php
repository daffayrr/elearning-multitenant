<?php

namespace App\Controllers;

class S3TestController extends BaseController
{
    public function index()
    {
        $s3 = new \App\Libraries\AwsS3Service();
        $fileName = 'test_controller_' . time() . '.txt';
        file_put_contents(WRITEPATH . 'uploads/' . $fileName, 'Hello from CI4 controller!');
        
        $result = $s3->uploadFile(WRITEPATH . 'uploads/' . $fileName, 'materials/' . $fileName);
        
        if ($result) {
            echo "Success: " . $result;
        } else {
            echo "Failed. Error log: ";
            if (file_exists(WRITEPATH . 'logs/s3_error.txt')) {
                echo file_get_contents(WRITEPATH . 'logs/s3_error.txt');
            } else {
                echo "No error log found.";
            }
        }
    }
}
