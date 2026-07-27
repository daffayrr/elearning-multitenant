<?php

namespace App\Libraries;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use Aws\Exception\MultipartUploadException;   // Fix P1009/PHP0413: namespace yang benar

/**
 * StorageManager — IDrive e2 (S3 Compatible) Library
 *
 * Prerequisite:
 *   composer require aws/aws-sdk-php
 *
 * .env yang diperlukan:
 *   storage.idrive_e2.key       = YOUR_ACCESS_KEY_ID
 *   storage.idrive_e2.secret    = YOUR_SECRET_ACCESS_KEY
 *   storage.idrive_e2.region    = e2-us-east-1
 *   storage.idrive_e2.bucket    = your-bucket-name
 *   storage.idrive_e2.endpoint  = https://e2-us-east-1.storage.idrivecloud.io
 *   storage.idrive_e2.url_expiry = 3600
 */
class StorageManager
{
    protected S3Client $client;

    protected string $bucket;
    protected string $endpoint;
    protected string $region;
    protected int    $urlExpiry;

    protected array $allowedMimeTypes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'video/mp4',
        'video/webm',
        'video/quicktime',
        'audio/mpeg',
        'audio/wav',
        'audio/ogg',
        'text/plain',
        'text/csv',
        'application/zip',
        'application/x-zip-compressed',
    ];

    protected int $maxFileSizeBytes = 524_288_000; // 500 MB

    // ═════════════════════════════════════════════════════════════════════
    // CONSTRUCTOR
    // ═════════════════════════════════════════════════════════════════════
    public function __construct()
    {
        $key      = env('storage.idrive_e2.key');
        $secret   = env('storage.idrive_e2.secret');
        $region   = env('storage.idrive_e2.region');
        $endpoint = env('storage.idrive_e2.endpoint');
        $bucket   = env('storage.idrive_e2.bucket');
        $expiry   = (int) env('storage.idrive_e2.url_expiry', 3600);

        $missing = array_filter([
            'storage.idrive_e2.key'      => $key,
            'storage.idrive_e2.secret'   => $secret,
            'storage.idrive_e2.region'   => $region,
            'storage.idrive_e2.endpoint' => $endpoint,
            'storage.idrive_e2.bucket'   => $bucket,
        ], fn($v) => empty($v));

        if (! empty($missing)) {
            $keys = implode(', ', array_keys($missing));
            log_message('critical', "[StorageManager] Konfigurasi .env tidak lengkap: {$keys}");
            throw new \RuntimeException(
                "Konfigurasi IDrive e2 tidak lengkap. Periksa .env: {$keys}"
            );
        }

        $this->bucket    = $bucket;
        $this->endpoint  = rtrim($endpoint, '/');
        $this->region    = $region;
        $this->urlExpiry = $expiry;

        $this->client = new S3Client([
            'version'                 => 'latest',
            'region'                  => $this->region,
            'endpoint'                => $this->endpoint,
            'use_path_style_endpoint' => true,   // WAJIB untuk IDrive e2
            'credentials'             => [
                'key'    => $key,
                'secret' => $secret,
            ],
            'retries' => 3,
            'http'    => [
                'connect_timeout' => 10,
                'timeout'         => 300,
            ],
        ]);
    }

    // ═════════════════════════════════════════════════════════════════════
    // METHOD: uploadFile
    // ═════════════════════════════════════════════════════════════════════

    /**
     * Upload file ke IDrive e2
     *
     * @param  string      $filePath  Path lokal file (dari $file->getTempName())
     * @param  string      $fileName  Key/path di bucket: "tenant-3/materi/slide.pdf"
     * @param  string      $fileType  MIME type: "application/pdf"
     * @param  string|null $bucket    Override bucket (null = dari .env)
     * @param  bool        $isPublic  true = public-read, false = private
     * @return array{success: bool, key: string, url: string, size: int, message: string}
     */
    public function uploadFile(
        string  $filePath,
        string  $fileName,
        string  $fileType,
        ?string $bucket = null,
        bool    $isPublic = false
    ): array {
        $bucket = $bucket ?? $this->bucket;

        if (! file_exists($filePath) || ! is_readable($filePath)) {
            return $this->errorResponse("File tidak ditemukan atau tidak dapat dibaca: {$filePath}");
        }

        $detectedMime = mime_content_type($filePath);
        $mimeToCheck  = $detectedMime ?: $fileType;

        if (! in_array($mimeToCheck, $this->allowedMimeTypes, true)) {
            return $this->errorResponse(
                "Tipe file tidak diizinkan: {$mimeToCheck}."
            );
        }

        $fileSize = filesize($filePath);
        if ($fileSize > $this->maxFileSizeBytes) {
            $maxMb = $this->maxFileSizeBytes / 1_048_576;
            return $this->errorResponse(
                "Ukuran file melebihi batas maksimum {$maxMb} MB. " .
                "Ukuran file: " . round($fileSize / 1_048_576, 2) . " MB"
            );
        }

        $safeKey = $this->sanitizeKey($fileName);

        try {
            // MultipartUploader menangani file kecil & besar secara otomatis
            $uploader = new \Aws\S3\MultipartUploader($this->client, $filePath, [
                'bucket'      => $bucket,
                'key'         => $safeKey,
                'ContentType' => $mimeToCheck,
                'ACL'         => $isPublic ? 'public-read' : 'private',
            ]);

            $result = $uploader->upload();

            $objectUrl = $isPublic
                ? (string) $result['ObjectURL']
                : $this->getFileUrl($safeKey, $bucket);

            log_message('info', sprintf(
                '[StorageManager] Upload sukses. Key: %s | Bucket: %s | Size: %s bytes',
                $safeKey, $bucket, $fileSize
            ));

            return [
                'success' => true,
                'key'     => $safeKey,
                'url'     => $objectUrl,
                'size'    => $fileSize,
                'message' => 'Upload berhasil.',
            ];

        } catch (MultipartUploadException $e) {
            // Fix: Aws\Exception\MultipartUploadException (bukan Aws\S3\Exception\)
            $this->abortMultipartUpload($e, $bucket, $safeKey);
            log_message('error', '[StorageManager] Multipart upload gagal: ' . $e->getMessage());
            return $this->errorResponse('Upload file gagal (multipart): ' . $e->getMessage());

        } catch (S3Exception $e) {
            log_message('error', '[StorageManager] S3Exception saat upload: ' . $e->getAwsErrorMessage());
            return $this->errorResponse('Upload file gagal: ' . $e->getAwsErrorMessage());

        } catch (AwsException $e) {
            log_message('error', '[StorageManager] AwsException saat upload: ' . $e->getMessage());
            return $this->errorResponse('Upload file gagal (AWS): ' . $e->getMessage());

        } catch (\Throwable $e) {
            log_message('error', '[StorageManager] Exception tidak terduga saat upload: ' . $e->getMessage());
            return $this->errorResponse('Upload file gagal (internal): ' . $e->getMessage());
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    // METHOD: getFileUrl
    // ═════════════════════════════════════════════════════════════════════

    /**
     * Generate pre-signed URL untuk akses sementara ke private object
     *
     * @param  string      $fileName  Key object di bucket
     * @param  string|null $bucket    Override bucket
     * @param  int|null    $expiry    Durasi validitas dalam detik
     * @return string                 Pre-signed URL
     * @throws \RuntimeException
     */
    public function getFileUrl(string $fileName, ?string $bucket = null, ?int $expiry = null): string
    {
        $bucket  = $bucket  ?? $this->bucket;
        $expiry  = $expiry  ?? $this->urlExpiry;
        $safeKey = $this->sanitizeKey($fileName);

        try {
            if (! $this->fileExists($safeKey, $bucket)) {
                throw new \RuntimeException(
                    "Object tidak ditemukan di bucket '{$bucket}': {$safeKey}"
                );
            }

            $command = $this->client->getCommand('GetObject', [
                'Bucket'                     => $bucket,
                'Key'                        => $safeKey,
                'ResponseContentDisposition' => 'inline; filename="' . basename($safeKey) . '"',
            ]);

            $presignedRequest = $this->client->createPresignedRequest(
                $command,
                "+{$expiry} seconds"
            );

            $url = (string) $presignedRequest->getUri();

            log_message('info', sprintf(
                '[StorageManager] Pre-signed URL dibuat. Key: %s | Expiry: %ds',
                $safeKey, $expiry
            ));

            return $url;

        } catch (\RuntimeException $e) {
            throw $e;

        } catch (S3Exception $e) {
            log_message('error', '[StorageManager] S3Exception saat getFileUrl: ' . $e->getAwsErrorMessage());
            throw new \RuntimeException('Gagal mendapatkan URL file: ' . $e->getAwsErrorMessage());

        } catch (AwsException $e) {
            log_message('error', '[StorageManager] AwsException saat getFileUrl: ' . $e->getMessage());
            throw new \RuntimeException('Gagal mendapatkan URL file (AWS): ' . $e->getMessage());

        } catch (\Throwable $e) {
            log_message('error', '[StorageManager] Exception tidak terduga saat getFileUrl: ' . $e->getMessage());
            throw new \RuntimeException('Gagal mendapatkan URL file (internal): ' . $e->getMessage());
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    // METHOD: deleteFile
    // ═════════════════════════════════════════════════════════════════════

    /**
     * @return array{success: bool, key: string, url: string, size: int, message: string}
     */
    public function deleteFile(string $fileName, ?string $bucket = null): array
    {
        $bucket  = $bucket ?? $this->bucket;
        $safeKey = $this->sanitizeKey($fileName);

        try {
            $this->client->deleteObject([
                'Bucket' => $bucket,
                'Key'    => $safeKey,
            ]);

            log_message('info', "[StorageManager] Delete sukses: {$bucket}/{$safeKey}");

            return [
                'success' => true,
                'key'     => $safeKey,
                'url'     => '',
                'size'    => 0,
                'message' => 'File berhasil dihapus.',
            ];

        } catch (S3Exception $e) {
            log_message('error', '[StorageManager] S3Exception saat delete: ' . $e->getAwsErrorMessage());
            return $this->errorResponse('Hapus file gagal: ' . $e->getAwsErrorMessage());

        } catch (AwsException $e) {
            log_message('error', '[StorageManager] AwsException saat delete: ' . $e->getMessage());
            return $this->errorResponse('Hapus file gagal (AWS): ' . $e->getMessage());
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    // METHOD: fileExists
    // ═════════════════════════════════════════════════════════════════════

    public function fileExists(string $fileName, ?string $bucket = null): bool
    {
        $bucket  = $bucket ?? $this->bucket;
        $safeKey = $this->sanitizeKey($fileName);

        try {
            return $this->client->doesObjectExist($bucket, $safeKey);
        } catch (AwsException $e) {
            log_message('error', '[StorageManager] Exception saat fileExists: ' . $e->getMessage());
            return false;
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    // METHOD: createTenantBucket
    // ═════════════════════════════════════════════════════════════════════

    /**
     * @return array{success: bool, key: string, url: string, size: int, message: string}
     */
    public function createTenantBucket(string $bucketName): array
    {
        if (! preg_match('/^[a-z0-9\-]{3,63}$/', $bucketName)) {
            return $this->errorResponse(
                'Nama bucket tidak valid. Gunakan huruf kecil, angka, dan strip (3-63 karakter).'
            );
        }

        try {
            $this->client->createBucket(['Bucket' => $bucketName]);

            $this->client->putPublicAccessBlock([
                'Bucket' => $bucketName,
                'PublicAccessBlockConfiguration' => [
                    'BlockPublicAcls'       => true,
                    'BlockPublicPolicy'     => true,
                    'IgnorePublicAcls'      => true,
                    'RestrictPublicBuckets' => true,
                ],
            ]);

            log_message('info', "[StorageManager] Bucket dibuat: {$bucketName}");

            return [
                'success' => true,
                'key'     => $bucketName,
                'url'     => '',
                'size'    => 0,
                'message' => "Bucket '{$bucketName}' berhasil dibuat.",
            ];

        } catch (S3Exception $e) {
            if ($e->getAwsErrorCode() === 'BucketAlreadyOwnedByYou') {
                return [
                    'success' => true,
                    'key'     => $bucketName,
                    'url'     => '',
                    'size'    => 0,
                    'message' => "Bucket '{$bucketName}' sudah ada.",
                ];
            }

            log_message('error', '[StorageManager] S3Exception createBucket: ' . $e->getAwsErrorMessage());
            return $this->errorResponse('Gagal membuat bucket: ' . $e->getAwsErrorMessage());

        } catch (AwsException $e) {
            log_message('error', '[StorageManager] AwsException createBucket: ' . $e->getMessage());
            return $this->errorResponse('Gagal membuat bucket (AWS): ' . $e->getMessage());
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    // METHOD: ping
    // ═════════════════════════════════════════════════════════════════════

    /**
     * @return array{success: bool, key: string, url: string, size: int, message: string, buckets?: array}
     */
    public function ping(): array
    {
        try {
            $result  = $this->client->listBuckets();
            $buckets = array_column($result['Buckets'], 'Name');

            return [
                'success' => true,
                'key'     => '',
                'url'     => '',
                'size'    => 0,
                'message' => 'Koneksi ke IDrive e2 berhasil.',
                'buckets' => $buckets,
            ];

        } catch (AwsException $e) {
            log_message('error', '[StorageManager] Ping gagal: ' . $e->getMessage());
            return $this->errorResponse('Koneksi ke IDrive e2 gagal: ' . $e->getMessage());
        }
    }

    // ═════════════════════════════════════════════════════════════════════
    // PRIVATE HELPERS
    // ═════════════════════════════════════════════════════════════════════

    private function sanitizeKey(string $key): string
    {
        $key = str_replace(["\0", '../', '.\\'], '', $key);
        $key = str_replace('\\', '/', $key);
        $key = preg_replace('#/+#', '/', $key);
        $key = ltrim($key, '/');

        if (strlen($key) > 1024) {
            $ext = pathinfo($key, PATHINFO_EXTENSION);
            $key = substr($key, 0, 1020) . ($ext ? ".{$ext}" : '');
        }

        return $key;
    }

    /**
     * Batalkan multipart upload yang gagal agar tidak meninggalkan fragment berbayar
     */
    private function abortMultipartUpload(
        MultipartUploadException $e,   // Fix: pakai alias dari use statement
        string $bucket,
        string $key
    ): void {
        try {
            $state    = $e->getState();
            $uploadId = $state->getId();

            if ($uploadId) {
                $this->client->abortMultipartUpload([
                    'Bucket'   => $bucket,
                    'Key'      => $key,
                    'UploadId' => $uploadId,
                ]);
                log_message('info', "[StorageManager] Multipart upload dibatalkan: {$key}");
            }
        } catch (\Throwable $abort) {
            log_message('error', '[StorageManager] Gagal membatalkan multipart: ' . $abort->getMessage());
        }
    }

    /**
     * @return array{success: bool, key: string, url: string, size: int, message: string}
     */
    private function errorResponse(string $message): array
    {
        return [
            'success' => false,
            'key'     => '',
            'url'     => '',
            'size'    => 0,
            'message' => $message,
        ];
    }
}