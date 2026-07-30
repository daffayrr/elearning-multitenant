<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\StorageManager;

class DownloadController extends Controller
{
    public function s3($tenant)
    {
        $url = $this->request->getGet('url');
        if (empty($url)) {
            return redirect()->back()->with('error', 'URL tidak valid');
        }

        $bucket = env('storage.idrive_e2.bucket');
        
        // Find the bucket in the URL to extract the key
        $search = '/' . $bucket . '/';
        $pos = strpos($url, $search);
        
        if ($pos !== false) {
            $key = substr($url, $pos + strlen($search));
            
            $sm = new StorageManager();
            try {
                $presignedUrl = $sm->getFileUrl($key);
                return redirect()->to($presignedUrl);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal memuat file dari S3: ' . $e->getMessage());
            }
        }
        
        // If we can't parse it, just redirect to the raw URL
        return redirect()->to($url);
    }
}
