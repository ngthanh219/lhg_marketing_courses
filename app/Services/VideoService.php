<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Jobs\UploadVideoJob;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class VideoService extends BaseService
{
    protected $course;
    protected $courseSection;
    protected $video;
    protected $awsS3Service;

    public function __construct(
        Course $course,
        CourseSection $courseSection,
        Video $video,
        AWSS3Service $awsS3Service
    ) {
        $this->course = $course;
        $this->courseSection = $courseSection;
        $this->video = $video;
        $this->awsS3Service = $awsS3Service;
    }

    public function index($request)
    {
        try {
            $courseName = null;
            $courseSectionName = null;
            $videos = $this->video;

            if (isset($request->course_section_id)) {
                $courseSection = $this->courseSection->find($request->course_section_id);

                if (!$courseSection) {
                    return $this->responseError(__('messages.course_section.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $course = $this->course->find($courseSection->course_id);

                if (!$course) {
                    return $this->responseError(__('messages.course.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }
                
                $courseName = $course->name;
                $courseSectionName = $courseSection->name;
                $videos = $videos->where('course_section_id', $request->course_section_id);
            }

            if (isset($request->id_sort)) {
                $videos = $videos->orderBy('id', $request->id_sort);
            }

            if (isset($request->name)) {
                $videos = $videos->where('name', 'like', '%' . $request->name . '%');
            }

            if (isset($request->is_show)) {
                if ($request->is_show != Constant::IS_ALL_SHOW) {
                    $videos = $videos->where('is_show', $request->is_show);
                }
            }

            if (isset($request->is_deleted)) {
                if ($request->is_deleted == Constant::IS_DELETED) {
                    $videos = $videos->onlyTrashed();
                }
            }

            $data = $this->pagination($videos, $request, [
                'course_name' => $courseName,
                'course_section_name' => $courseSectionName
            ]);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $courseSection = $this->courseSection->find($request->course_section_id);

            if (!$courseSection) {
                DB::rollBack();
                return $this->responseError(__('messages.course_section.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $source = null;
            $newData = [
                'course_section_id' => (int) $request->course_section_id,
                'name' => $request->name,
                'duration' => (int) $request->duration,
                'is_show' => (int) $request->is_show
            ];

            // if (isset($request->source)) {
            //     $request->file = $request->source;
            //     $source = $this->awsS3Service->uploadFile($request, Constant::VIDEO_FOLDER);
            //     $newData['source'] = $source;
            // }

            return response()->json(file_get_contents($request->source));
            $video = $this->video->create($newData);
            if (isset($request->source)) {
                UploadVideoJob::dispatch(file_get_contents($request->source), $request->source->getClientOriginalExtension(), $video->id);
            }

            DB::commit();

            return $this->responseSuccess($video);
        } catch (\Exception $ex) {
            DB::rollBack();
            $this->awsS3Service->removeFile($source);
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function update($request, $id)
    {
        try {
            $video = $this->video->find($id);

            if (!$video) {
                return $this->responseError(__('messages.video.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $courseSection = $this->courseSection->find($request->course_section_id);

            if (!$courseSection) {
                return $this->responseError(__('messages.course_section.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $source = null;
            $updatedData = [
                'course_section_id' => $request->course_section_id,
                'name' => $request->name,
                'duration' => $request->duration,
                'is_show' => $request->is_show
            ];

            if ($request->is_change_video === "true") {
                $request->file = $request->source;
                $source = $this->awsS3Service->uploadFile($request, Constant::VIDEO_FOLDER);
                $updatedData['source'] = $source;
                $this->awsS3Service->removeFile($video->source);
            }

            $video->update($updatedData);

            return $this->responseSuccess($video);
        } catch (\Exception $ex) {
            $this->awsS3Service->removeFile($source);
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function delete($request, $id)
    {
        try {
            $video = $this->video->find($id);
            
            if (!$video) {
                $video = $this->video->withTrashed()->where('id', $id)->first();

                if (!$video) {
                    return $this->responseError(__('messages.video.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $video->restore();
            } else {
                $video->delete();
            }

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function uploadFile($request)
    {
        try {
            if (isset($request->file) && isset($request->folder)) {
                $image = $this->awsS3Service->uploadFile($request, $request->folder . '/');

                return $this->responseSuccess(config('base.aws.s3.url') . $image);
            }
            
            return $this->responseSuccess(null, [], 'Thất bại');
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
