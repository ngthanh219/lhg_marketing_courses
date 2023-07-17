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
        // return response()->json(\Illuminate\Support\Facades\Crypt::decrypt("eyJpdiI6IkpDc1dFUGxQV012MHlKMFFUNXorMHc9PSIsInZhbHVlIjoiNWpvcjJrWEo5dGFPTmVEdUhxUTR2cE9FVnlhRkNmamo3TTNxUER0NUtVdz0iLCJtYWMiOiI2ZWEwN2UwNGMxYmFhZTAzZDdjYjI1OTEyMGIwMzMyZGJhZDQ0ZWQxZTM1OTIyMTQ2OWZiZDQ3Njk1Nzk3NjhiIiwidGFnIjoiIn0="));
        $video =  $this->awsS3Service->getFile($request);

        return view('welcome', [
            'video' => $video
        ]);
    }
}
