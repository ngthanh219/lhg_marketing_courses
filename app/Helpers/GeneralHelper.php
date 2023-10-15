<?php

namespace App\Helpers;

use App\Libraries\Constant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GeneralHelper
{
    public static function detachException($functionName, $title, $information = [], $isInfo = false)
    {
        $error = json_encode([
            'function' => $functionName,
            'title' => $title,
            'information' => $information
        ]);

        if ($isInfo) {
            Log::info($error);
        } else {
            Log::error($error);
        }
    }

    public static function uploadFile($file)
    {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        Storage::disk(Constant::STORAGE_DISK_CUSTOM_LOCAL)->put($fileName, file_get_contents($file));

        return $fileName;
    }

    public static function removeFile($path)
    {
        if ($path && Storage::disk(Constant::STORAGE_DISK_CUSTOM_LOCAL)->exists($path)) {
            Storage::disk(Constant::STORAGE_DISK_CUSTOM_LOCAL)->delete($path);
        }
    }
}
