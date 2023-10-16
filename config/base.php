<?php

return [
    'storage_disk' => env('STORAGE_DISK'),      // local and s3
    'domain' => env('DOMAIN'),
    'image_url' => env('IMAGE_URL'),
    'aws' => [
        's3' => [
            'url' => env('AWS_URL') . '/'
        ]
    ]
];
