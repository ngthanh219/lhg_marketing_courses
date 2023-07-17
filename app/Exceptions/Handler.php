<?php

namespace App\Exceptions;

use App\Libraries\ErrorCode;
use App\Services\BaseService;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected $baseService;

    public function __construct(Container $container, BaseService $baseService)
    {
        parent::__construct($container);

        $this->baseService = $baseService;
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        Log::error($exception->getMessage());

        if (preg_match('/api\//', $request->getRequestUri()) || preg_match('/\//', $request->getRequestUri())) {
            if ($exception instanceof ValidationException) {
                return $this->baseService->responseError($exception->getMessage(), 400, ErrorCode::VALIDATION_ERROR, ['validation' => $exception->errors()]);
            }

            if ($exception instanceof NotFoundHttpException) {
                return $this->baseService->responseError(__('messages.system.api_not_found'), 404, ErrorCode::API_NOT_FOUND);
            }

            if (!$exception instanceof ValidationException) {
                return $this->baseService->responseError($exception->getMessage(), 500, ErrorCode::SERVER_ERROR);
            }
        }

        return parent::render($request, $exception);
    }
}
