<?php

return [
    'storage_disk' => env('STORAGE_DISK'),      // local and s3
    'aws' => [
        's3' => [
            'url' => env('AWS_URL') . '/'
        ]
    ]
];
