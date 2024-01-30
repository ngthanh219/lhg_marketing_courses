<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected $fileService;

    public function __construct(
        FileService $fileService
    ) {
        $this->fileService = $fileService;
    }

    public function uploadFile(Request $request)
    {
        return $this->fileService->uploadFile($request);
    }

    public function removeFile(Request $request)
    {
        return $this->fileService->removeFile($request);
    }
}
