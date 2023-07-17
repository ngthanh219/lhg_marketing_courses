<?php

namespace App\Http\Controllers;

use App\Services\AWSS3Service;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected $awsS3Service;

    public function __construct(
        AWSS3Service $awsS3Service
    ) {
        $this->awsS3Service = $awsS3Service;
    }

    public function getVideo(Request $request)
    {
        $video =  $this->awsS3Service->getFile($request);

        return view('welcome', [
            'video' => $video
        ]);
    }
}
