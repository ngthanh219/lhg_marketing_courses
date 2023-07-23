<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\VideoService;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(
        VideoService $videoService
    ) {
        $this->videoService = $videoService;
    }

    public function index(Request $request)
    {
        return $this->videoService->index($request);
    }
}
