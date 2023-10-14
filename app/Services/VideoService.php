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
                'duration' => (int) $request->duration,
                'is_show' => (int) $request->is_show
            ];

            if ($request->source) {
                $newData['source'] = $request->source;
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

    public function getVideoObject($request)
    {
        try {
            $files = Storage::disk(Constant::STORAGE_DISK_LOCAL)->files(Constant::VIDEO_FOLDER);
            $data = [];

            foreach ($files as $file) {
                $fileName = str_replace(Constant::VIDEO_FOLDER, '', $file);
                $createdAt = str_replace('.mp4', '', $fileName);
                $data[] = [
                    'key' => $file,
                    'created_at' => date('d-m-Y H:i:s', $createdAt)
                ];
            }

            if (isset($request->last_modified_sort)) {
                if ($request->last_modified_sort == 'desc') {
                    usort($data, function ($a, $b) {
                        return strtotime($b['created_at']) - strtotime($a['created_at']);
                    });
                } else {
                    usort($data, function ($a, $b) {
                        return strtotime($a['created_at']) - strtotime($b['created_at']);
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
                $time = time();
                $fileName = "$time.mp4";
            }

            $key .= $fileName;
            if (Storage::disk(Constant::STORAGE_DISK_LOCAL)->exists($key)) {
                return $this->responseError(__('messages.video.name_exist'), 400, ErrorCode::PARAM_EXISTS);
            }

            Storage::disk(Constant::STORAGE_DISK_LOCAL)->put($key, '');
            $uploadId = str_replace('.mp4', '', $fileName);

            return $this->responseSuccess([
                'upload_id' => $uploadId,
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
            $chunkFolder = Constant::CHUNK_FOLDER . $request->upload_id . '/blob_' . $request->part_number;
            Storage::disk(Constant::STORAGE_DISK_LOCAL)->put($chunkFolder, file_get_contents($request->file));
            $sourceFile = fopen(Storage::disk(Constant::STORAGE_DISK_LOCAL)->path($chunkFolder), 'r');
            $destinationFile = fopen(Storage::disk(Constant::STORAGE_DISK_LOCAL)->path($request->key), 'a');
            while (($line = fgets($sourceFile)) !== false) {
                fwrite($destinationFile, $line);
            }
    
            fclose($destinationFile);
            fclose($sourceFile);
            Storage::disk(Constant::STORAGE_DISK_LOCAL)->delete($chunkFolder);

            return response()->json([
                'success' => 1,
                'part_number_continue' => $request->part_number + 1
            ]);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function completeMultipartUpload($request)
    {
        try {
            $chunkFolder = Constant::CHUNK_FOLDER . $request->upload_id;
            Storage::disk(Constant::STORAGE_DISK_LOCAL)->deleteDirectory($chunkFolder);

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function deleteVideoObject($request)
    {
        try {
            if (Storage::disk(Constant::STORAGE_DISK_LOCAL)->exists($request->key)) {
                Storage::disk(Constant::STORAGE_DISK_LOCAL)->delete($request->key);
            }

            return $this->responseSuccess($request->key);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function showVideoObject($request)
    {
        try {
            if (!Storage::disk(Constant::STORAGE_DISK_LOCAL)->exists($request->key)) {
                return $this->responseError(__('messages.video.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $video = Storage::disk(Constant::STORAGE_DISK_LOCAL)->path($request->key);

            return response()->file($video, ['Content-Type' => 'video/mp4']);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
