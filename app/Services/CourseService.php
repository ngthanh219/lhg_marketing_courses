<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Models\Course;

class CourseService extends BaseService
{
    protected $course;
    protected $awsS3Service;

    public function __construct(
        Course $course,
        AWSS3Service $awsS3Service
    ) {
        $this->course = $course;
        $this->awsS3Service = $awsS3Service;
    }

    public function index($request)
    {
        try {
            $courses = $this->course->withCount('courseSections');

            if (isset($request->id_sort)) {
                $courses = $courses->orderBy('id', $request->id_sort);
            }

            if (isset($request->name)) {
                $courses = $courses->where('name', 'like', '%' . $request->name . '%');
            }

            if (isset($request->is_show)) {
                if ($request->is_show != Constant::IS_ALL_SHOW) {
                    $courses = $courses->where('is_show', $request->is_show);
                }
            }

            if (isset($request->is_deleted)) {
                if ($request->is_deleted == Constant::IS_DELETED) {
                    $courses = $courses->onlyTrashed();
                }
            }

            $data = $this->pagination($courses, $request);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function create($request)
    {
        try {
            $image = null;
            $newData = [
                'name' => $request->name,
                'slogan' => $request->slogan,
                'introduction' => $request->introduction,
                'description' => $request->description,
                'price' => (double) $request->price,
                'discount' => (int) $request->discount,
                'is_show' => (int) $request->is_show,
                'discount_price' => (double) ($request->price - (($request->price * ($request->discount / 100)) * 100 / 100))
            ];

            if (isset($request->image_url)) {
                $request->file = $request->image_url;
                $image = $this->awsS3Service->uploadFile($request, Constant::IMAGE_FOLDER);
                $newData['image'] = $image;
            }

            $course = $this->course->create($newData);

            return $this->responseSuccess($course);
        } catch (\Exception $ex) {
            $this->awsS3Service->removeFile($image);
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function update($request, $id)
    {
        try {
            $course = $this->course->find($id);
            
            if (!$course) {
                return $this->responseError(__('messages.course.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $image = null;
            $updatedData = [
                'name' => $request->name,
                'slogan' => $request->slogan,
                'introduction' => $request->introduction,
                'description' => $request->description,
                'price' => (double) $request->price,
                'discount' => (int) $request->discount,
                'is_show' => (int) $request->is_show,
                'discount_price' => (double) ($request->price - (($request->price * ($request->discount / 100)) * 100 / 100))
            ];

            if ($request->is_change_image === "true") {
                $request->file = $request->image_url;
                $image = $this->awsS3Service->uploadFile($request, Constant::IMAGE_FOLDER);
                $updatedData['image'] = $image;
                $this->awsS3Service->removeFile($course->image);
            }

            $course->update($updatedData);

            return $this->responseSuccess($course);
        } catch (\Exception $ex) {
            $this->awsS3Service->removeFile($image);
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function delete($request, $id)
    {
        try {
            $course = $this->course->find($id);
            
            if (!$course) {
                $course = $this->course->withTrashed()->where('id', $id)->first();

                if (!$course) {
                    return $this->responseError(__('messages.course.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $course->restore();
            } else {
                $course->delete();
            }

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
