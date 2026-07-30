<?php

namespace App\Libraries;

class AwsS3Service
{
    protected $storageManager;

    public function __construct()
    {
        $this->storageManager = new \App\Libraries\StorageManager();
    }

    /**
     * Upload a file to S3
     * 
     * @param string $filePath The local path of the file to upload
     * @param string $destinationPath The path in the S3 bucket
     * @return string|bool URL of the uploaded file on success, false on failure
     */
    public function uploadFile(string $filePath, string $destinationPath)
    {
        try {
            // Determine mime type if possible
            $mime = mime_content_type($filePath) ?: 'application/octet-stream';
            
            $result = $this->storageManager->uploadFile($filePath, $destinationPath, $mime, null, true);
            
            if ($result['success']) {
                $url = $result['url'];
                if (strpos($url, 'http://') === 0) {
                    $url = 'https://' . substr($url, 7);
                }
                return $url;
            }
            
            log_message('error', 'S3 Upload Error: ' . $result['message']);
            file_put_contents(WRITEPATH . 'logs/s3_error.txt', $result['message']);
            return false;
        } catch (\Exception $e) {
            log_message('error', 'S3 Upload Error: ' . $e->getMessage());
            file_put_contents(WRITEPATH . 'logs/s3_error.txt', $e->getMessage());
            return false;
        }
    }
}
