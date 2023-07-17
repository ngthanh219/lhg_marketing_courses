<?php

namespace App\Services;

use Aws\S3\S3Client;
use Illuminate\Support\Str;

class AWSS3Service
{
    public function connect()
    {
        
    }

    public function getFile($request)
    {
        $bucket = config('filesystems.disks.s3.bucket');
        $expires = '+30 second';

        $s3Client = new S3Client([
            'region' => config('filesystems.disks.s3.region'),
            'version' => 'latest',
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret')
            ],
        ]);

        $command = $s3Client->getCommand('GetObject', [
            'Bucket' => $bucket,
            'Key' => 'videos/ex.mp4'
        ]);

        $request = $s3Client->createPresignedRequest($command, $expires);
        $presignedUrl = (string) $request->getUri();

        return $presignedUrl;
    }
}
