<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\GetUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    public function index(GetUserRequest $request)
    {
        return $this->userService->index($request);
    }

    public function create(CreateUserRequest $request)
    {
        return $this->userService->create($request);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        return $this->userService->update($request, $id);
    }

    public function delete(Request $request, $id)
    {
        return $this->userService->delete($request, $id);
    }
}
