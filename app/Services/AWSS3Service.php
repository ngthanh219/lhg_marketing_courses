<?php

namespace App\Services;

use Aws\S3\S3Client;
use Illuminate\Support\Facades\Storage;

class AWSS3Service
{
    public function getFile($filePath, $expireDuration)
    {
        $bucket = config('filesystems.disks.s3.bucket');
        $expires = "+$expireDuration second";

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
            'Key' => $filePath
        ]);

        $request = $s3Client->createPresignedRequest($command, $expires);
        $presignedUrl = (string) $request->getUri();

        return $presignedUrl;
    }

    public function uploadFile($request, $folder)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $filePath = $folder . $fileName;

        Storage::disk('s3')->put($filePath, file_get_contents($request->file));

        return $filePath;
    }

    public function removeFile($filePath)
    {
        if ($filePath != null) {
            if (is_array($filePath)) {
                foreach ($filePath as $path) {
                    $this->delete($path);
                }
            } else {
                $this->delete($filePath);
            }
        }
    }

    public function delete($path)
    {
        if (Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
        }
    }
}
