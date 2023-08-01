<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(
        AuthService $authService
    ) {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->loginAdmin($request);
    }

    public function logout(Request $request)
    {
        return $this->authService->logoutAdmin($request);
    }
}
