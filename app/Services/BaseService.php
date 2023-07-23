<?php

namespace App\Services;

use App\Libraries\ErrorCode;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class BaseService
{
    public function pagination($models, $request, $otherParams = [])
    {
        $models = $models->paginate($request->limit, ['*'], 'page', $request->page);

        return $this->convertPagination($models, $otherParams);
    }

    public function convertPagination(LengthAwarePaginator $awarePaginator, $otherParams = [])
    {
        $response = [
            'total_record' => $awarePaginator->total(),
            'total_page' => $awarePaginator->lastPage(),
            'list' => $awarePaginator->items()
        ];

        foreach ($otherParams as $key => $param) {
            $response[$key] = $param;
        }

        return $response;
    }

    public function responseSuccess($data = null, $appends = [], $message = '')
    {
        $response['success'] = 1;

        if ($data) {
            $response['data'] = $data;
        } else {
            $response['message'] = $message ? $message : __('messages.data_status.success');
        }

        Log::info(json_encode([
            'url' => request()->url(),
            'method' => request()->method(),
            'body' => request()->all(),
            'status_code' => 200,
            'message' => $message,
        ], JSON_UNESCAPED_UNICODE));

        return response()->json(array_merge($response, $appends));
    }

    public function responseError($errorMessage, $httpCode = 500, $errorCode = ErrorCode::SERVER_ERROR, $appends = [])
    {
        $errorCode = 'E' . str_pad($errorCode, 4, 0, STR_PAD_LEFT);

        if ($httpCode == 400 || $httpCode == 500) {
            Log::error(json_encode([
                'url' => request()->url(),
                'method' => request()->method(),
                'body' => request()->all(),
                'status_code' => $httpCode,
                'message' => $errorMessage,
            ], JSON_UNESCAPED_UNICODE));
        }

        return response()->json(array_merge([
            'success' => 0,
            'error' => [
                'error_code' => $errorCode,
                'error_message' => $errorMessage,
            ],
        ], $appends), $httpCode);
    }
}
