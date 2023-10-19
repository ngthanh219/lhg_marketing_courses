<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
        try {
            $courseSection = $this->courseSection->find($request->course_section_id);
            if (!$courseSection) {
                return $this->responseError(__('messages.course_section.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $newData = [
                'course_section_id' => (int) $request->course_section_id,
                'name' => $request->name,
                'duration' => 0,
                'is_show' => (int) $request->is_show
            ];

            if ($request->source) {
                $newData['source'] = $request->source;
                $newData['duration'] = GeneralHelper::getVideoDuration($request->source);
            }

            $video = $this->video->create($newData);

            return $this->responseSuccess($video);
        } catch (\Exception $ex) {
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

            $updatedData = [
                'course_section_id' => $request->course_section_id,
                'name' => $request->name,
                'duration' => $request->duration,
                'is_show' => $request->is_show
            ];

            if ($request->source) {
                $updatedData['source'] = $request->source;
                $updatedData['duration'] = GeneralHelper::getVideoDuration($request->source);
            }

            $video->update($updatedData);

            return $this->responseSuccess($video);
        } catch (\Exception $ex) {
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

    public function getVideoObjectInS3($request)
    {
        try {
            $data = null;
            if ($request->path) {
                $data = $this->awsS3Service->getObject($request->path, Constant::EXPIRE_VIDEO);
            } else {
                $data = $this->awsS3Service->getObjects(Constant::VIDEO_FOLDER);
    
                foreach ($data as $key => $item) {
                    $data[$key]['LastModified'] = Carbon::parse($data[$key]['LastModified'], 'Asia/Ho_Chi_Minh')->format("d-m-Y H:i:s");

                    if ($item['Key'] == Constant::VIDEO_FOLDER) {
                        unset($data[$key]);
                    }
                }

                if (isset($request->last_modified_sort) && $request->last_modified_sort == 'desc') {
                    usort($data, function ($a, $b) {
                        return strtotime($b['LastModified']) - strtotime($a['LastModified']);
                    });
                }
            }

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function createMultipartUpload($request)
    {
        try {
            $key = Constant::VIDEO_FOLDER;
            if ($request->file_name) {
                $fileName = $request->file_name;
            } else {
                $time = GeneralHelper::randomString(80) . '_' . time();
                $fileName = "$time.mp4";
            }

            $key .= $fileName;
            if ($this->awsS3Service->checkObjectExists($key)) {
                return $this->responseError(__('messages.video.name_exist'), 400, ErrorCode::PARAM_EXISTS);
            }

            $res = $this->awsS3Service->createMultipartUpload($key);

            return $this->responseSuccess([
                'upload_id' => $res,
                'key' => $key
            ]);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function signMultipartUpload($request)
    {
        try {
            $request['part_number'] += 1;
            $res = $this->awsS3Service->signMultipartUpload($request);

            return response()->json([
                'success' => 1,
                'data' => $res
            ]);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function completeMultipartUpload($request)
    {
        try {
            $request['file_parts'] = json_decode($request['file_parts'], true);
            $this->awsS3Service->completeMultipartUpload($request);
            GeneralHelper::handleVideoContentFile([
                'key' => $request->key,
                'duration' => $request->duration
            ]);
            $link = $this->awsS3Service->getObject($request->key, Constant::EXPIRE_VIDEO);

            return $this->responseSuccess($link);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function abortMultipartUpload($request)
    {
        try {
            $res = $this->awsS3Service->abortMultipartUpload($request);

            return $this->responseSuccess($res);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function deleteObject($request)
    {
        try {
            $this->awsS3Service->removeFile($request->key);
            GeneralHelper::deleteVideoContentFile($request->key);

            return $this->responseSuccess($request->key);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
