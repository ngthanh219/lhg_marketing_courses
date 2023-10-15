<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Models\Post;
use Illuminate\Support\Str;

class PostService extends BaseService
{
    protected $post;

    public function __construct(
        Post $post
    ) {
        $this->post = $post;
    }

    public function index($request)
    {
        try {
            $posts = $this->post;

            if (isset($request->id_sort)) {
                $posts = $posts->orderBy('id', $request->id_sort);
            }

            if (isset($request->name)) {
                $posts = $posts->where('name', 'like', '%' . $request->name . '%');
            }

            if (isset($request->is_show)) {
                if ($request->is_show != Constant::IS_ALL_SHOW) {
                    $posts = $posts->where('is_show', $request->is_show);
                }
            }

            if (isset($request->is_deleted)) {
                if ($request->is_deleted == Constant::IS_DELETED) {
                    $posts = $posts->onlyTrashed();
                }
            }

            $data = $this->pagination($posts, $request);

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
            $checkSlug = $this->post->where('slug', $slug)->withTrashed()->first();
            
            if ($checkSlug) {
                return $this->responseError(__('messages.post.exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $newData = [
                'name' => $request->name,
                'slug' => $slug,
                'content' => $request->content,
                'is_show' => (int) $request->is_show
            ];

            if (isset($request->image_url)) {
                $image = GeneralHelper::uploadFile($request->image_url);
                $newData['image'] = $image;
            }

            $post = $this->post->create($newData);

            return $this->responseSuccess($post);
        } catch (\Exception $ex) {
            GeneralHelper::removeFile($image);
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function update($request, $id)
    {
        try {
            $post = $this->post->find($id);
            
            if (!$post) {
                return $this->responseError(__('messages.post.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $image = null;
            $slug = Str::slug($request->name);
            $checkSlug = $this->post->where('id', '!=', $id)
                ->where('slug', $slug)
                ->withTrashed()
                ->first();
            
            if ($checkSlug) {
                return $this->responseError(__('messages.post.exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $updatedData = [
                'name' => $request->name,
                'slug' => $slug,
                'content' => $request->content,
                'is_show' => (int) $request->is_show
            ];

            if ($request->is_change_image === "true") {
                $image = GeneralHelper::uploadFile($request->image_url);
                $updatedData['image'] = $image;
                GeneralHelper::removeFile($post->image);
            }

            $post->update($updatedData);

            return $this->responseSuccess($post);
        } catch (\Exception $ex) {
            GeneralHelper::removeFile($image);
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function delete($request, $id)
    {
        try {
            $post = $this->post->find($id);
            
            if (!$post) {
                $post = $this->post->withTrashed()->where('id', $id)->first();

                if (!$post) {
                    return $this->responseError(__('messages.post.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $post->restore();
            } else {
                $post->delete();
            }

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function getPostsClient($request)
    {
        try {
            $posts = $this->post->where('is_show', Constant::IS_SHOW);

            if (isset($request->id_sort)) {
                $posts = $posts->orderBy('id', $request->id_sort);
            }

            if (isset($request->is_deleted)) {
                if ($request->is_deleted == Constant::IS_DELETED) {
                    $posts = $posts->onlyTrashed();
                }
            }

            $data = $this->pagination($posts, $request);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function getPostDetailClient($postSlug)
    {
        try {
            $post = $this->post->where('slug', $postSlug)
                ->where('is_show', Constant::IS_SHOW)
                ->first();

            if (!$post) {
                return $this->responseError(__('messages.post.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            return $this->responseSuccess($post);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
