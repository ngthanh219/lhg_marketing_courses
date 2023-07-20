<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\ErrorCode;
use App\Models\User;

class UserService extends BaseService
{
    protected $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    public function index($request)
    {
        try {
            $users = $this->user;
            $data = $this->pagination($users, $request);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
