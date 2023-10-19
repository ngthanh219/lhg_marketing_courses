<?php

namespace App\Helpers;

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

    public static function handleVideoContentFile($contents)
    {
        $videoContentsFile = 'video_contents.json';
        $disk = 'public';
        
        if (!Storage::disk($disk)->exists($videoContentsFile)) {
            Storage::disk($disk)->put($videoContentsFile, json_encode([$contents]));
        } else {
            $videoContents = json_decode(Storage::disk($disk)->get($videoContentsFile), true);
            $index = -1;
            foreach ($videoContents as $i => $videoContent) {
                if ($contents['key'] == $videoContent['key']) {
                    $index = $i;
                    break;
                }
            }

            if ($index == -1) {
                $videoContents[] = $contents;
            } else {
                $videoContents[$index]['key'] = $contents['key'];
                $videoContents[$index]['duration'] = $contents['duration'];
            }
            
            Storage::disk($disk)->put($videoContentsFile, json_encode($videoContents));
        }
    }

    public static function getVideoDuration($key)
    {
        $videoContentsFile = 'video_contents.json';
        $disk = 'public';
        $videoContents = json_decode(Storage::disk($disk)->get($videoContentsFile), true);

        foreach ($videoContents as $videoContent) {
            if ($videoContent['key'] == $key) {
                return $videoContent['duration'];
            }
        }
    }

    public static function deleteVideoContentFile($key)
    {
        $videoContentsFile = 'video_contents.json';
        $disk = 'public';
        $videoContents = json_decode(Storage::disk($disk)->get($videoContentsFile), true);

        foreach ($videoContents as $index => $videoContent) {
            if ($videoContent['key'] == $key) {
                unset($videoContents[$index]);
            }
        }

        Storage::disk($disk)->put($videoContentsFile, json_encode($videoContents));
    }

    public static function randomString($length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}
