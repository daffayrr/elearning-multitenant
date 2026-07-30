<?php
require __DIR__ . '/vendor/autoload.php';

// parse .env manually line by line
$envFile = __DIR__ . '/.env';
$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$env = [];
foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    $parts = explode('=', $line, 2);
    if (count($parts) === 2) {
        $env[trim($parts[0])] = trim($parts[1]);
    }
}

$key = $env['storage.idrive_e2.key'] ?? '';
$secret = $env['storage.idrive_e2.secret'] ?? '';
$region = $env['storage.idrive_e2.region'] ?? '';
$endpoint = $env['storage.idrive_e2.endpoint'] ?? '';
$bucket = $env['storage.idrive_e2.bucket'] ?? '';

echo "Testing S3 Configuration...\n";
echo "Endpoint: " . $endpoint . "\n";
echo "Region: " . $region . "\n";
echo "Bucket: " . $bucket . "\n";

try {
    $s3 = new \Aws\S3\S3Client([
        'version' => 'latest',
        'region'  => $region,
        'endpoint' => 'https://' . $endpoint,
        'credentials' => [
            'key'    => $key,
            'secret' => $secret,
        ],
        'use_path_style_endpoint' => true,
        'http' => [
            'verify' => false
        ]
    ]);

    $fileName = 'test_' . time() . '.txt';
    file_put_contents(__DIR__ . '/' . $fileName, 'Hello S3 from standalone test!');

    echo "Attempting to upload $fileName...\n";

    $result = $s3->putObject([
        'Bucket' => $bucket,
        'Key'    => $fileName,
        'SourceFile' => __DIR__ . '/' . $fileName,
        'ACL'    => 'public-read',
    ]);

    echo "Upload Success!\n";
    echo "URL: https://" . $endpoint . "/" . $bucket . "/" . $fileName . "\n";

    unlink(__DIR__ . '/' . $fileName);
} catch (\Exception $e) {
    echo "S3 Upload Error: " . $e->getMessage() . "\n";
}
