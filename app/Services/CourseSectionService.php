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

    public function index($request)
    {
        try {
            $courseName = null;
            $courseSections = $this->courseSection->withCount('videos');

            if (isset($request->course_id)) {
                $course = $this->course->find($request->course_id);

                if (!$course) {
                    return $this->responseError(__('messages.course.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $courseName = $course->name;
                $courseSections = $courseSections->where('course_id', $course->id);
            }

            if (isset($request->id_sort)) {
                $courseSections = $courseSections->orderBy('id', $request->id_sort);
            }

            if (isset($request->name)) {
                $courseSections = $courseSections->where('name', 'like', '%' . $request->name . '%');
            }

            if (isset($request->is_show)) {
                if ($request->is_show != Constant::IS_ALL_SHOW) {
                    $courseSections = $courseSections->where('is_show', $request->is_show);
                }
            }

            if (isset($request->is_deleted)) {
                if ($request->is_deleted == Constant::IS_DELETED) {
                    $courseSections = $courseSections->onlyTrashed();
                }
            }

            $data = $this->pagination($courseSections, $request, [
                'course_name' => $courseName
            ]);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function update($request, $id)
    {
        try {
            $courseSection = $this->courseSection->find($id);

            if (!$courseSection) {
                return $this->responseError(__('messages.course_section.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $course = $this->course->find($request->course_id);

            if (!$course) {
                return $this->responseError(__('messages.course.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $courseSection->update($request->only(
                'course_id',
                'name',
                'description',
                'is_show'
            ));

            return $this->responseSuccess($courseSection);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function delete($request, $id)
    {
        try {
            $courseSection = $this->courseSection->find($id);
            
            if (!$courseSection) {
                $courseSection = $this->courseSection->withTrashed()->where('id', $id)->first();

                if (!$courseSection) {
                    return $this->responseError(__('messages.course_section.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $courseSection->restore();
            } else {
                $courseSection->delete();
            }

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
