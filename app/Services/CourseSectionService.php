<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Models\Course;
use App\Models\CourseSection;

class CourseSectionService extends BaseService
{
    protected $course;
    protected $courseSection;

    public function __construct(
        Course $course,
        CourseSection $courseSection
    ) {
        $this->course = $course;
        $this->courseSection = $courseSection;
    }

    public function getSectionsByCourse($request, $courseId)
    {
        try {
            $course = $this->course->find($courseId);

            if (!$course) {
                return $this->responseError(__('messages.course.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $courseSections = $this->courseSection->where('course_id', $courseId);

            if (isset($request->id_sort)) {
                $courseSections = $courseSections->orderBy('id', $request->id_sort);
            }

            if (isset($request->name)) {
                $courseSections = $courseSections->where('name', 'like', $request->name . '%');
            }

            if (isset($request->is_show)) {
                if ($request->is_show != Constant::IS_ALL_SHOW) {
                    $courseSections = $courseSections->where('is_show', $request->is_show);
                }
            }

            $data = $this->pagination($courseSections, $request, [
                'course_name' => $course->name
            ]);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
