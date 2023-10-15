<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Video;
use App\Models\CourseUser;
use App\Models\User;

class CourseUserService extends BaseService
{
    protected $user;
    protected $course;
    protected $courseSection;
    protected $video;
    protected $courseUser;

    public function __construct(
        User $user,
        Course $course,
        CourseSection $courseSection,
        Video $video,
        CourseUser $courseUser
    ) {
        $this->user = $user;
        $this->course = $course;
        $this->courseSection = $courseSection;
        $this->video = $video;
        $this->courseUser = $courseUser;
    }

    public function index($request)
    {
        try {
            $courseUsers = $this->courseUser;

            if (isset($request->status_sort)) {
                $courseUsers = $courseUsers->orderBy('status', $request->status_sort);
            }

            if (isset($request->id_sort)) {
                $courseUsers = $courseUsers->orderBy('id', $request->id_sort);
            }

            if (isset($request->is_show)) {
                if ($request->is_show != Constant::IS_ALL_SHOW) {
                    $courseUsers = $courseUsers->where('is_show', $request->is_show);
                }
            }

            if (isset($request->is_deleted)) {
                if ($request->is_deleted == Constant::IS_DELETED) {
                    $courseUsers = $courseUsers->onlyTrashed();
                }
            }

            $data = $this->pagination($courseUsers, $request);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function create($request)
    {
        try {
            $user = $this->user->where('id', $request->user_id)
                ->where('role_id', Constant::ROLE_CLIENT)
                ->first();
            if (!$user) {
                return $this->responseError(__('messages.user.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $course = $this->course->where('id', $request->course_id)->first();
            if (!$course) {
                return $this->responseError(__('messages.course.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $courseUser = $this->courseUser->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();
            if ($courseUser) {
                return $this->responseError(__('messages.course_user.registered_user'), 400, ErrorCode::PARAM_INVALID);
            }

            $billingImage = null;
            $newData = [
                'user_id' => (int) $request->user_id,
                'course_id' => (int) $request->course_id,
                'price' => $course->price,
                'discount' => $course->discount,
                'discount_price' => $course->discount_price,
                'status' => (int) $request->status,
                'is_show' => (int) $request->is_show
            ];

            if (isset($request->billing_image_url)) {
                $billingImage = GeneralHelper::uploadFile($request->billing_image_url);
                $newData['billing_image'] = $billingImage;
            }

            $courseUser = $this->courseUser->create($newData);

            return $this->responseSuccess($courseUser);
        } catch (\Exception $ex) {
            GeneralHelper::removeFile($billingImage);
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function update($request, $id)
    {
        try {
            $courseUser = $this->courseUser->find($id);
            if (!$courseUser) {
                return $this->responseError(__('messages.course_user.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $billingImage = null;
            $updatedData = [
                'status' => (int) $request->status,
                'is_show' => (int) $request->is_show
            ];

            if ($request->is_change_billing_image === "true" && isset($request->billing_image_url)) {
                $billingImage = GeneralHelper::uploadFile($request->billing_image_url);
                $updatedData['billing_image'] = $billingImage;
                GeneralHelper::removeFile($courseUser->billing_image);
            }

            $courseUser->update($updatedData);

            return $this->responseSuccess($courseUser);
        } catch (\Exception $ex) {
            GeneralHelper::removeFile($billingImage);
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function delete($request, $id)
    {
        try {
            $courseUser = $this->courseUser->find($id);
            
            if (!$courseUser) {
                $courseUser = $this->courseUser->withTrashed()->where('id', $id)->first();

                if (!$courseUser) {
                    return $this->responseError(__('messages.course_user.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $availableCourseUser = $this->courseUser->where('user_id', $courseUser->user_id)
                    ->where('course_id', $courseUser->course_id)
                    ->first();

                if ($availableCourseUser) {
                    return $this->responseError(__('messages.course_user.not_restore'), 400, ErrorCode::PARAM_INVALID);
                }

                $courseUser->restore();
            } else {
                $courseUser->delete();
            }

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
