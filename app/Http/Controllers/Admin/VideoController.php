<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateVideoRequest;
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

    public function update(UpdateVideoRequest $request, $id)
    {
        return $this->videoService->update($request, $id);
    }

    public function delete(Request $request, $id)
    {
        return $this->videoService->delete($request, $id);
    }
}
