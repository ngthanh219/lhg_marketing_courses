<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Libraries\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService extends BaseService
{
    protected $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    public function login($request)
    {
        try {
            $authentication = auth()->guard('web')->attempt([
                'role_id' => Constant::ROLE_ADMIN,
                'email' => $request->email,
                'password' => $request->password,
                'deleted_at' => null
            ]);

            if (!$authentication) {
                return $this->responseError(__('messages.auth.login_error'), 400, ErrorCode::PARAM_INVALID);
            }

            $accessToken = Auth::user()->createToken('WebAuth')->accessToken;
            $user = auth()->guard('web')->user();

            return $this->responseSuccess([
                'access_token' => $accessToken,
                'user' => $user
            ]);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
