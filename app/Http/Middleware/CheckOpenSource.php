<?php

namespace App\Http\Middleware;

use App\Libraries\ErrorCode;
use App\Services\BaseService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOpenSource
{
    protected $baseService;

    public function __construct(
        BaseService $baseService
    ) {
        $this->baseService = $baseService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        try {
            $referer = $request->header('Referer');
            if (strpos($referer, config('base.domain'))) {
                return $next($request);
            }

            return $this->baseService->responseError(__('messages.system.not_access'), 501, ErrorCode::API_NOT_FOUND);
        } catch (\Exception $ex) {
            return $this->baseService->responseError(__('messages.system.cannot_server'), 503, ErrorCode::SERVER_ERROR);
        }
    }
}
