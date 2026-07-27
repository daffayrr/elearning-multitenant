<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Konfigurasi IDrive e2 (S3-Compatible Object Storage)
 * 
 * IDrive e2 menggunakan S3 API, sehingga SDK AWS S3 / Flysystem S3
 * dapat digunakan langsung dengan mengganti endpoint.
 * 
 * Endpoint format: https://<region>.storage.idrivecloud.io
 * Daftar region: e2-us-west-1, e2-us-east-1, e2-eu-central-1, dll.
 * Cek dashboard IDrive e2 untuk endpoint region Anda.
 */
class Storage extends BaseConfig
{
    // ─── Driver default ───────────────────────────────────────────────────
    public string $default = 'idrive_e2';

    // ─── Konfigurasi IDrive e2 ────────────────────────────────────────────
    public array $disks = [
        'idrive_e2' => [
            'driver'   => 's3',
            'key'      => '',           // Isi via .env: storage.idrive_e2.key
            'secret'   => '',           // Isi via .env: storage.idrive_e2.secret
            'region'   => '',           // Contoh: e2-us-west-1
            'bucket'   => '',           // Nama bucket default
            'endpoint' => '',           // Contoh: https://e2-us-west-1.storage.idrivecloud.io
            'use_path_style_endpoint' => true, // WAJIB true untuk IDrive e2
            'url'      => '',           // Public URL jika bucket public (opsional)
        ],

        // Disk lokal untuk development/fallback
        'local' => [
            'driver' => 'local',
            'root'   => WRITEPATH . 'uploads',
        ],
    ];
}