<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class VideoService extends BaseService
{
    protected $course;
    protected $courseSection;
    protected $video;

    public function __construct(
        Course $course,
        CourseSection $courseSection,
        Video $video
    ) {
        $this->course = $course;
        $this->courseSection = $courseSection;
        $this->video = $video;
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

    public function getVideoObject($request)
    {
        try {
            $files = Storage::disk(Constant::STORAGE_DISK_LOCAL)->files(Constant::VIDEO_FOLDER);
            $data = [];

            foreach ($files as $file) {
                $data[] = [
                    'key' => $file
                ];
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
    
    public function abortMultipartUpload($request)
    {
        try {
            Storage::disk(Constant::STORAGE_DISK_LOCAL)->deleteDirectory(Constant::CHUNK_FOLDER . $request->upload_id);
            Storage::disk(Constant::STORAGE_DISK_LOCAL)->delete($request->key);

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

            // return response()->file($video, ['Content-Type' => 'video/mp4']);

            return response()->stream(
                function () use ($video) {
                    $fileStream = fopen($video, 'rb');
                    while (!feof($fileStream)) {
                        echo fread($fileStream, 5 * 1024 * 1024);
                        ob_flush();
                        flush();
                    }
                    fclose($fileStream);
                },
                200,
                [
                    'Content-Type' => 'application/octet-stream',
                    'Content-Disposition' => 'attachment; filename="' . basename($video) . '"',
                ]
            );
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function uploadGeneralFile($request)
    {
        try {
            $upload = GeneralHelper::uploadFile($request->file, $request->file_name);

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
