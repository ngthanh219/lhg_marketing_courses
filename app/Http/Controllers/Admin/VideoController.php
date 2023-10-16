<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVideoRequest;
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

    public function create(CreateVideoRequest $request)
    {
        return $this->videoService->create($request);
    }

    public function update(UpdateVideoRequest $request, $id)
    {
        return $this->videoService->update($request, $id);
    }

    public function delete(Request $request, $id)
    {
        return $this->videoService->delete($request, $id);
    }

    public function getVideoObject(Request $request)
    {
        return $this->videoService->getVideoObject($request);
    }

    public function createMultipartUpload(Request $request)
    {
        return $this->videoService->createMultipartUpload($request);
    }

    public function signMultipartUpload(Request $request)
    {
        return $this->videoService->signMultipartUpload($request);
    }

    public function completeMultipartUpload(Request $request)
    {
        return $this->videoService->completeMultipartUpload($request);
    }

    public function abortMultipartUpload(Request $request)
    {
        return $this->videoService->abortMultipartUpload($request);
    }

    public function deleteVideoObject(Request $request)
    {
        return $this->videoService->deleteVideoObject($request);
    }

    public function showVideoObject(Request $request)
    {
        return $this->videoService->showVideoObject($request);
    }

    public function uploadGeneralFile(Request $request)
    {
        return $this->videoService->uploadGeneralFile($request);
    }
}
