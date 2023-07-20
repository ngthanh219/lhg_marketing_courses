<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

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
}
