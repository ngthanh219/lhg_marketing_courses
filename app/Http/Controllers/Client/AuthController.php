<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SendVerifyCodeRequest;
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
        return $this->authService->loginClient($request);
    }

    public function sendVerifyCode(SendVerifyCodeRequest $request)
    {
        return $this->authService->sendVerifyCode($request);
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request);
    }
}
