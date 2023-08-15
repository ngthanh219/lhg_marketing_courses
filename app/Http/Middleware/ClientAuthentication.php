<?php

namespace App\Http\Middleware;

use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Services\BaseService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientAuthentication
{
    protected $baseService;

    public function __construct(
        BaseService $baseService
    ) {
        $this->baseService = $baseService;
    }

    public function handle($request, Closure $next, ...$guard)
    {
        try {
            if (auth()->guard('api')->check()) {
                if (auth()->guard('api')->user()->role_id == Constant::ROLE_CLIENT) {
                    return $next($request);
                }
            }

            return $this->baseService->responseError(__('messages.auth.auth_error'), 401, ErrorCode::AUTH_ERROR);
        } catch (\Exception $ex) {
            return $this->baseService->responseError(__('messages.system.cannot_server'), 503, ErrorCode::SERVER_ERROR);
        }
    }
}
