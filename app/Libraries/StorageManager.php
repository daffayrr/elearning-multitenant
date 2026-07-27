<?php

namespace App\Libraries;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Config\Storage as StorageConfig;

/**
 * StorageManager — Abstraksi upload/download IDrive e2
 * 
 * Install dependency: composer require aws/aws-sdk-php
 * 
 * Penggunaan:
 *   $storage = new \App\Libraries\StorageManager();
 *   $url = $storage->upload($file, 'materi/course-1/modul.pdf', $tenantBucket);
 */
class StorageManager
{
    protected S3Client $client;
    protected array $config;

    public function __construct()
    {
        $cfg = config('Storage');
        $this->config = $cfg->disks['idrive_e2'];

        // Override dari .env jika ada
        $this->config['key']      = env('storage.idrive_e2.key',      $this->config['key']);
        $this->config['secret']   = env('storage.idrive_e2.secret',   $this->config['secret']);
        $this->config['region']   = env('storage.idrive_e2.region',   $this->config['region']);
        $this->config['bucket']   = env('storage.idrive_e2.bucket',   $this->config['bucket']);
        $this->config['endpoint'] = env('storage.idrive_e2.endpoint', $this->config['endpoint']);

        $this->client = new S3Client([
            'version'                 => 'latest',
            'region'                  => $this->config['region'],
            'endpoint'                => $this->config['endpoint'],
            'use_path_style_endpoint' => true, // WAJIB untuk IDrive e2
            'credentials'             => [
                'key'    => $this->config['key'],
                'secret' => $this->config['secret'],
            ],
        ]);
    }

    /**
     * Upload file ke IDrive e2
     *
     * @param  \CodeIgniter\HTTP\Files\UploadedFile $file      File dari request
     * @param  string                               $path      Path di dalam bucket, contoh: "tenant-3/materi/file.pdf"
     * @param  string|null                          $bucket    Override bucket (per-tenant bucket opsional)
     * @return string                               URL object yang diupload
     * @throws \RuntimeException
     */
    public function upload(\CodeIgniter\HTTP\Files\UploadedFile $file, string $path, ?string $bucket = null): string
    {
        $bucket = $bucket ?? $this->config['bucket'];

        // Sanitasi nama file — hindari path traversal
        $safePath = $this->sanitizePath($path);

        try {
            $result = $this->client->putObject([
                'Bucket'      => $bucket,
                'Key'         => $safePath,
                'Body'        => fopen($file->getTempName(), 'rb'),
                'ContentType' => $file->getMimeType(),
                // ACL: gunakan 'private' untuk materi berbayar/restricted
                // gunakan 'public-read' untuk materi publik
                'ACL'         => 'private',
            ]);

            log_message('info', "[Storage] Upload sukses: {$bucket}/{$safePath}");

            return (string) $result['ObjectURL'];

        } catch (AwsException $e) {
            log_message('error', '[Storage] Upload gagal: ' . $e->getMessage());
            throw new \RuntimeException('Upload file gagal: ' . $e->getAwsErrorMessage());
        }
    }

    /**
     * Generate pre-signed URL untuk akses temporary (private objects)
     * Berguna untuk streaming video/materi tanpa expose bucket secara langsung
     *
     * @param  string $key        Path object di bucket
     * @param  string $bucket     Nama bucket
     * @param  int    $expiry     Durasi validitas URL dalam detik (default 1 jam)
     * @return string             Pre-signed URL
     */
    public function getPresignedUrl(string $key, string $bucket = '', int $expiry = 3600): string
    {
        $bucket = $bucket ?: $this->config['bucket'];

        $cmd = $this->client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key'    => $key,
        ]);

        $request = $this->client->createPresignedRequest($cmd, "+{$expiry} seconds");

        return (string) $request->getUri();
    }

    /**
     * Hapus object dari bucket
     */
    public function delete(string $key, ?string $bucket = null): bool
    {
        $bucket = $bucket ?? $this->config['bucket'];

        try {
            $this->client->deleteObject([
                'Bucket' => $bucket,
                'Key'    => $key,
            ]);

            log_message('info', "[Storage] Delete sukses: {$bucket}/{$key}");
            return true;

        } catch (AwsException $e) {
            log_message('error', '[Storage] Delete gagal: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Buat bucket baru (dipanggil saat tenant baru dibuat)
     */
    public function createBucket(string $bucketName): bool
    {
        try {
            $this->client->createBucket(['Bucket' => $bucketName]);
            log_message('info', "[Storage] Bucket dibuat: {$bucketName}");
            return true;
        } catch (AwsException $e) {
            log_message('error', '[Storage] Create bucket gagal: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Cek koneksi ke IDrive e2 (health check)
     */
    public function ping(): bool
    {
        try {
            $this->client->listBuckets();
            return true;
        } catch (AwsException $e) {
            log_message('error', '[Storage] Ping gagal: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Sanitasi path — cegah path traversal
     */
    private function sanitizePath(string $path): string
    {
        // Hapus ../ dan karakter berbahaya
        $path = str_replace(['../', '..\\', "\0"], '', $path);
        // Normalisasi slash
        $path = ltrim(preg_replace('#/+#', '/', $path), '/');
        return $path;
    }
}