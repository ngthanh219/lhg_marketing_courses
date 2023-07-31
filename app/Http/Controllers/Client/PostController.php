<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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

    public function getPosts(Request $request)
    {
        return $this->postService->getPostsClient($request);
    }

    public function getPostDetail($postSlug)
    {
        return $this->postService->getPostDetailClient($postSlug);
    }
}
