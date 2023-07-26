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

            if (isset($request->role_id)) {
                $users = $users->where('role_id', $request->role_id);
            }

            if (isset($request->id_sort)) {
                $users = $users->orderBy('id', $request->id_sort);
            }

            if (isset($request->information)) {
                $key = 'email';

                if (is_numeric($request->information)) {
                    $key = 'phone';
                }

                $users = $users->where($key, 'like', '%' . $request->information . '%');
            }

            if (isset($request->is_login)) {
                if ($request->is_login != Constant::IS_ALL_LOGGED) {
                    $users = $users->where('is_login', $request->is_login);
                }
            }

            if (isset($request->is_deleted)) {
                if ($request->is_deleted == Constant::IS_DELETED) {
                    $users = $users->onlyTrashed();
                }
            }

            $data = $this->pagination($users, $request);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function create($request)
    {
        try {
            $existEmail = $this->user->where('email', $request->email)->withTrashed()->first();
            if ($existEmail) {
                return $this->responseError(__('messages.user.email_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $existPhone = $this->user->where('phone', $request->phone)->withTrashed()->first();
            if ($existPhone) {
                return $this->responseError(__('messages.user.phone_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $newData = [
                'role_id' => $request->role_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'email_verified_at' => now(),
                'is_login' => $request->is_login
            ];

            $data = $this->user->create($newData);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function update($request, $id)
    {
        try {
            $user = $this->user->find($id);
            
            if (!$user) {
                return $this->responseError(__('messages.user.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            if ($request->email !== $user->email) {
                $existEmail = $this->user->where('id', '!=', $user->id)
                    ->where('email', $request->email)
                    ->first();

                if ($existEmail) {
                    return $this->responseError(__('messages.user.email_exist'), 400, ErrorCode::PARAM_INVALID);
                }
            }

            if ($request->phone !== $user->phone) {
                $existPhone = $this->user->where('id', '!=', $user->id)
                    ->where('phone', $request->phone)
                    ->first();

                if ($existPhone) {
                    return $this->responseError(__('messages.user.phone_exist'), 400, ErrorCode::PARAM_INVALID);
                }
            }

            $updatedData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'is_login' => $request->is_login,
                'role_id' => $request->role_id
            ];

            if ($request->is_change_password) {
                $updatedData['password'] = bcrypt($request->password);
            }

            $user->update($updatedData);

            return $this->responseSuccess($user);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function delete($request, $id)
    {
        try {
            $user = $this->user->find($id);
            
            if (!$user) {
                $user = $this->user->withTrashed()->where('id', $id)->first();

                if (!$user) {
                    return $this->responseError(__('messages.user.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $user->restore();
            } else {
                $user->delete();
            }

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
