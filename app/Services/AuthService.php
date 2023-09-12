<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Jobs\SendVerificationCodeJob;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Libraries\Message;
use App\Mail\SendVerificationCodeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuthService extends BaseService
{
    protected $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    public function loginAdmin($request)
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

    public function logoutAdmin($request)
    {
        try {
            $user = auth()->guard('api')->user();
            DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function loginClient($request)
    {
        try {
            $authentication = auth()->guard('web')->attempt([
                'role_id' => Constant::ROLE_CLIENT,
                'email' => $request->email,
                'password' => $request->password,
                'deleted_at' => null
            ]);

            if (!$authentication) {
                return $this->responseError(__('messages.auth.login_error'), 400, ErrorCode::PARAM_INVALID);
            }
            
            $user = auth()->guard('web')->user();

            if ($user->email_verified_at === null) {
                return $this->responseError(__('messages.auth.not_verified_email'), 400, ErrorCode::NOT_VERIFIED_EMAIL);
            }

            if ($user->is_login === Constant::IS_LOGGED) {
                return $this->responseError(__('messages.auth.logged_email'), 400, ErrorCode::AUTH_ERROR);
            }
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }

        DB::beginTransaction();
        try {
            DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
            
            $user->update([
                'is_login' => Constant::IS_LOGGED
            ]);

            $accessToken = Auth::user()->createToken('WebAuth')->accessToken;
            $user = $this->user->find($user->id);
            DB::commit();

            return $this->responseSuccess([
                'access_token' => $accessToken,
                'user' => $user
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function sendVerifyCode($request)
    {
        try {
            $user = $this->user->where('email', $request->email)->withTrashed()->first();
            $verficationCode = rand(10000, 99999);

            if ($user) {
                if ($user->email_verified_at !== null) {
                    return $this->responseError(__('messages.user.email_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $user->update([
                    'verification_code' => $verficationCode,
                    'verification_code_at' => now()
                ]);
            } else {
                $this->user->create([
                    'role_id' => Constant::ROLE_CLIENT,
                    'email' => $request->email,
                    'verification_code' => $verficationCode,
                    'verification_code_at' => now()
                ]);
            }

            SendVerificationCodeJob::dispatch($request->email, $verficationCode);

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function register($request)
    {
        try {
            $user = $this->user->where("email", $request->email)
                ->where("verification_code", $request->verification_code)
                ->where("email_verified_at", null)
                ->first();

            if (!$user) {
                return $this->responseError(__('messages.user.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            if (Carbon::now()->diffInMinutes($user->verification_code_at) > 10) {
                return $this->responseError(__('messages.user.expired_verification_code'), 400, ErrorCode::PARAM_INVALID);
            }

            $existPhone = $this->user->where('phone', $request->phone)->first();
            if ($existPhone) {
                return $this->responseError(__('messages.user.phone_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'verification_code' => null,
                'verification_code_at' => null,
                'email_verified_at' => now()
            ]);

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
