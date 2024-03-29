<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseUser;
use App\Models\Video;
use Illuminate\Support\Str;

class CourseService extends BaseService
{
    protected $course;
    protected $courseSection;
    protected $video;
    protected $courseUser;
    protected $awsS3Service;

    public function __construct(
        Course $course,
        CourseSection $courseSection,
        Video $video,
        CourseUser $courseUser,
        AWSS3Service $awsS3Service
    ) {
        $this->course = $course;
        $this->courseSection = $courseSection;
        $this->video = $video;
        $this->courseUser = $courseUser;
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
            $slug = Str::slug($request->name);
            $checkSlug = $this->course->where('slug', $slug)->withTrashed()->first();
            
            if ($checkSlug) {
                return $this->responseError(__('messages.course.exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $newData = [
                'name' => $request->name,
                'slug' => $slug,
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
            $slug = Str::slug($request->name);
            $checkSlug = $this->course->where('id', '!=', $id)
                ->where('slug', $slug)
                ->withTrashed()
                ->first();
            
            if ($checkSlug) {
                return $this->responseError(__('messages.course.exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $updatedData = [
                'name' => $request->name,
                'slug' => $slug,
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

    public function getCoursesClient($request)
    {
        try {
            if (isset($request->is_user) && $request->is_user == true) {
                $user = auth()->guard('api')->user();

                if (!$user) {
                    return $this->responseError(__('messages.auth.auth_error'), 401, ErrorCode::AUTH_ERROR);
                }

                $courses = $this->course->select([
                    'courses.id',
                    'courses.name',
                    'courses.slug',
                    'courses.image',
                    'courses.price',
                    'courses.discount',
                    'courses.discount_price'
                ])->rightJoin('course_users', 'courses.id', '=', 'course_users.course_id')
                    ->where('courses.is_show', Constant::IS_SHOW)
                    ->where('courses.deleted_at', null)
                    ->where('course_users.is_show', Constant::IS_SHOW)
                    ->where('course_users.deleted_at', null)
                    ->where('course_users.user_id', $user->id)
                    ->orderByDesc('courses.id');
            } else {
                $courses = $this->course;

                if (isset($request->name)) {
                    $courses = $courses->where('name', 'like', '%' . $request->name . '%');
                }

                if (isset($request->price_sort)) {
                    $courses = $courses->orderBy('discount_price', $request->price_sort);
                }

                $courses = $courses->where('is_show', Constant::IS_SHOW)
                    ->select([
                        'id',
                        'name',
                        'slug',
                        'image',
                        'price',
                        'discount',
                        'discount_price'
                    ])
                    ->orderByDesc('id');
            }

            $data = $this->pagination($courses, $request);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function getCourseDetailClient($request, $courseSlug)
    {
        try {
            $course = $this->course->where('slug', $courseSlug)
                ->where('is_show', Constant::IS_SHOW)
                ->first();
            if (!$course) {
                return $this->responseError(__('messages.course.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $course->my_course = Constant::COURSE_USER_NO_ACTION;

            if (auth()->guard('api')->check()) {
                $user = auth()->guard('api')->user();

                if ($user) {
                    $courseUser = $this->courseUser->where('user_id', $user->id)
                        ->where('course_id', $course->id)
                        ->where('is_show', Constant::IS_SHOW)
                        ->first();

                    if ($courseUser) {
                        $course->my_course = $courseUser->status;
                    }
                }
            }

            $course->load([
                'courseSections' => function ($courseSection) use ($course) {
                    $courseSection->with([
                        'videos' => function ($video) use ($course) {
                            $videoField = [
                                'id',
                                'course_section_id',
                                'name',
                                'duration'
                            ];

                            if ($course->my_course == Constant::COURSE_USER_USING) {
                                $videoField[] = 'source';
                            }

                            $video->where('is_show', Constant::IS_SHOW)->select($videoField);
                        }
                    ])->where('is_show', Constant::IS_SHOW)->select([
                        'id',
                        'course_id',
                        'name',
                        'slug'
                    ]);
                }
            ]);

            $courseSections = $this->courseSection->where('course_id', $course->id)
                ->where('is_show', Constant::IS_SHOW)
                ->pluck('id');

            $totalVideo = $this->video->whereIn('course_section_id', $courseSections)
                ->where('is_show', Constant::IS_SHOW)
                ->count('id');

            $totalDuration = $this->video->whereIn('course_section_id', $courseSections)
                ->where('is_show', Constant::IS_SHOW)
                ->sum('duration');

            $response = [
                'course' => $course,
                'total_course_section' => (int) $totalVideo,
                'total_video_duration' => (int) $totalDuration
            ];

            return $this->responseSuccess($response);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function registerCourseClient($request)
    {
        try {
            $user = auth()->guard('api')->user();
            $course = $this->course->where('slug', $request->course_slug)
                ->where('is_show', Constant::IS_SHOW)
                ->first();

            if (!$course) {
                return $this->responseError(__('messages.course.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }
            
            $courseUser = $this->courseUser->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();

            if ($courseUser) {
                return $this->responseError(__('messages.course.registered_user'), 400, ErrorCode::PARAM_INVALID);
            }

            $billingImage = null;
            if (isset($request->billing_image_url)) {
                $request->file = $request->billing_image_url;
                $billingImage = $this->awsS3Service->uploadFile($request, Constant::IMAGE_FOLDER);
            }

            $courseUser = $this->courseUser->create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'price' => $course->price,
                'discount' => $course->discount,
                'discount_price' => $course->discount_price,
                'billing_image' => $billingImage,
                'description' => $request->description,
                'status' => Constant::COURSE_USER_PENDING,
                'is_show' => Constant::IS_SHOW
            ]);

            // TODO: handle send mail to Admin

            return $this->responseSuccess([
                'status' => $courseUser->status
            ]);
        } catch (\Exception $ex) {
            $this->awsS3Service->removeFile($billingImage);
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function decryptVideo($request)
    {
        try {
            $queryParams = null;
            $user = auth()->guard('api')->user();

            if (isset($request->id)) {
                $video = $this->video->find($request->id);

                if (!$video) {
                    return $this->responseError(__('messages.video.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $courseId = $video->load('courseSection')->courseSection->course_id;
                $courseUser = $this->courseUser->where('user_id', $user->id)
                    ->where('course_id', $courseId)
                    ->first();

                if (!$courseUser) {
                    return $this->responseError(__('messages.course_user.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $videoObject = (object) $video->toArray();
                $objectKey = GeneralHelper::reverseCustomSource($videoObject->source);
                $sourceUrl = $this->awsS3Service->getObject($objectKey, $videoObject->duration + Constant::EXPIRE_VIDEO);
                $query = parse_url($sourceUrl, PHP_URL_QUERY);
                parse_str($query, $queryParams);

                $queryParams = GeneralHelper::getSignedUrlParams($queryParams);
            }
            
            return $this->responseSuccess($queryParams);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
