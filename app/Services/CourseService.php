<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Models\Course;

class CourseService extends BaseService
{
    protected $course;

    public function __construct(
        Course $course
    ) {
        $this->course = $course;
    }

    public function index($request)
    {
        try {
            $courses = $this->course;

            if (isset($request->id_sort)) {
                $courses = $courses->orderBy('id', $request->id_sort);
            }

            if (isset($request->name)) {
                $courses = $courses->where('name', 'like', $request->name . '%');
            }

            if (isset($request->is_show)) {
                if ($request->is_show != Constant::IS_ALL_SHOW) {
                    $courses = $courses->where('is_show', $request->is_show);
                }
            }

            $data = $this->pagination($courses, $request);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
