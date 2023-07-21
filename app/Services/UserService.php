<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
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

            if (isset($request->id_sort)) {
                $users = $users->orderBy('id', $request->id_sort);
            }

            if (isset($request->information)) {
                $key = 'email';

                if (is_numeric($request->information)) {
                    $key = 'phone';
                }

                $users = $users->where($key, $request->information);
            }

            if (isset($request->is_login)) {
                if ($request->is_login != Constant::IS_ALL_LOGGED) {
                    $users = $users->where('is_login', $request->is_login);
                }
            }

            $data = $this->pagination($users, $request);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
