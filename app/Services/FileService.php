<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\ErrorCode;

class FileService extends BaseService
{
    protected $awsS3Service;

    public function __construct(
        AWSS3Service $awsS3Service
    ) {
        $this->awsS3Service = $awsS3Service;
    }

    public function uploadFile($request)
    {
        try {
            if (isset($request->file) && isset($request->folder)) {
                $image = $this->awsS3Service->uploadFile($request, $request->folder . '/');

                return $this->responseSuccess(config('base.aws.s3.url') . $image);
            }
            
            return $this->responseSuccess(null, [], 'Thất bại');
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function removeFile($request)
    {
        try {
            if (isset($request->key)) {
                $key = str_replace(config('base.aws.s3.url'), '', $request->key);
                $this->awsS3Service->removeFile($key);

                return $this->responseSuccess();
            }
            
            return $this->responseSuccess(null, [], 'Thất bại');
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
