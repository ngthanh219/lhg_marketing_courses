<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;

    public function __construct(
        PostService $postService
    ) {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        return $this->postService->index($request);
    }

    public function create(CreatePostRequest $request)
    {
        return $this->postService->create($request);
    }

    public function update(UpdatePostRequest $request, $id)
    {
        return $this->postService->update($request, $id);
    }

    public function delete(Request $request, $id)
    {
        return $this->postService->delete($request, $id);
    }
}
