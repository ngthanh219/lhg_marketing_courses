<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookUserRequest;
use App\Services\BookUserService;
use Illuminate\Http\Request;

class BookUserController extends Controller
{
    protected $bookUserService;

    public function __construct(
        BookUserService $bookUserService
    ) {
        $this->bookUserService = $bookUserService;
    }

    public function index(Request $request)
    {
        return $this->bookUserService->index($request);
    }

    public function update(UpdateBookUserRequest $request, $id)
    {
        return $this->bookUserService->update($request, $id);
    }

    public function delete(Request $request, $id)
    {
        return $this->bookUserService->delete($request, $id);
    }
}
