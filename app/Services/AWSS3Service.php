<?php

namespace App\Services;

use Aws\S3\S3Client;
use Illuminate\Support\Facades\Storage;

class AWSS3Service
{
    protected $bucket;

    public function __construct()
    {
        $this->bucket = config('filesystems.disks.s3.bucket');
    }

    public function s3ClientSetup()
    {
        return new S3Client([
            'region' => config('filesystems.disks.s3.region'),
            'version' => 'latest',
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret')
            ],
        ]);
    }

    public function getObjects($filePath = null)
    {
        $s3Client = $this->s3ClientSetup();

        $objects = $s3Client->listObjectsV2([
            'Bucket' => $this->bucket,
            'Prefix' => $filePath
        ]);

        return $objects['Contents'];
    }

    public function getFile($filePath, $expireDuration)
    {
        $expires = "+$expireDuration second";
        $s3Client = $this->s3ClientSetup();

        $command = $s3Client->getCommand('GetObject', [
            'Bucket' => $this->bucket,
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

    public function createMultipartUpload($key)
    {
        $s3Client = $this->s3ClientSetup();
        $result = $s3Client->createMultipartUpload([
            'Bucket' => $this->bucket,
            'Key' => $key,
            'ContentType' => 'video/mp4'
        ]);

        return $result['UploadId'];
    }

    public function signMultipartUpload($args)
    {
        $s3Client = $this->s3ClientSetup();
        $result = $s3Client->uploadPart([
            'Bucket' => $this->bucket,
            'Key' => $args['key'],
            'UploadId' => $args['upload_id'],
            'PartNumber' => $args['part_number'],
            'Body' => file_get_contents($args['file']),
        ]);

        return [
            'PartNumber' => $args['part_number'],
            'ETag' => $result['ETag'],
        ];
    }

    public function completeMultipartUpload($args)
    {
        $s3Client = $this->s3ClientSetup();

        return $s3Client->completeMultipartUpload([
            'Bucket' => $this->bucket,
            'Key' => $args['key'],
            'UploadId' => $args['upload_id'],
            'MultipartUpload' => [
                'Parts' => $args['file_parts']
            ],
        ]);
    }

    public function removeFile($key)
    {
        if ($key != null) {
            if (is_array($key)) {
                foreach ($key as $item) {
                    $this->delete($item);
                }
            } else {
                $this->delete($key);
            }
        }
    }

    public function checkObjectExists($key)
    {
        $s3Client = $this->s3ClientSetup();

        return $s3Client->doesObjectExist($this->bucket, $key);
    }

    public function delete($key)
    {
        if (Storage::disk('s3')->exists($key)) {
            Storage::disk('s3')->delete($key);
        }
    }

    public function abortMultipartUpload($args)
    {
        $s3Client = $this->s3ClientSetup();

        return $s3Client->abortMultipartUpload([
            'Bucket' => $this->bucket,
            'Key' => $args['key'],
            'UploadId' => $args['upload_id']
        ]);
    }
}
