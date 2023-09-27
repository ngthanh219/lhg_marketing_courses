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

    public function uploadFile(Request $request)
    {
        return $this->videoService->uploadFile($request);
    }

    public function getVideoObjectInS3(Request $request)
    {
        return $this->videoService->getVideoObjectInS3($request);
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

    public function deleteObject(Request $request)
    {
        return $this->videoService->deleteObject($request);
    }
}
