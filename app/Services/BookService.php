<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookService extends BaseService
{
    protected $book;
    protected $awsS3Service;

    public function __construct(
        Book $book,
        AWSS3Service $awsS3Service
    ) {
        $this->book = $book;
        $this->awsS3Service = $awsS3Service;
    }

    public function index($request)
    {
        try {
            $books = $this->book;

            if (isset($request->id_sort)) {
                $books = $books->orderBy('id', $request->id_sort);
            }

            if (isset($request->name)) {
                $books = $books->where('name', 'like', '%' . $request->name . '%');
            }

            if (isset($request->is_show)) {
                if ($request->is_show != Constant::IS_ALL_SHOW) {
                    $books = $books->where('is_show', $request->is_show);
                }
            }

            if (isset($request->is_deleted)) {
                if ($request->is_deleted == Constant::IS_DELETED) {
                    $books = $books->onlyTrashed();
                }
            }

            $data = $this->pagination($books, $request);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function create($request)
    {
        try {
            $slug = Str::slug($request->name);
            $checkSlug = $this->book->where('slug', $slug)->withTrashed()->first();
            if ($checkSlug) {
                return $this->responseError(__('messages.book.exist'), 400, ErrorCode::PARAM_INVALID);
            }
            
            $imageData = [];
            foreach ($request->image as $file) {
                $request->file = $file;
                $imageData[] = config('base.aws.s3.url') . $this->awsS3Service->uploadFile($request, Constant::BOOK_FOLDER);
            }

            $newData = [
                'name' => $request->name,
                'slug' => $slug,
                'introduction' => $request->introduction,
                'description' => $request->description,
                'image' => json_encode($imageData),
                'price' => (double) $request->price,
                'discount' => (int) $request->discount,
                'is_show' => (int) $request->is_show,
                'discount_price' => (double) ($request->price - (($request->price * ($request->discount / 100)) * 100 / 100))
            ];

            $book = $this->book->create($newData);

            return $this->responseSuccess($book);
        } catch (\Exception $ex) {
            $this->awsS3Service->removeFile($imageData);
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function update($request, $id)
    {
        try {
            $book = $this->book->find($id);
            if (!$book) {
                return $this->responseError(__('messages.book.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $slug = Str::slug($request->name);
            $checkSlug = $this->book->where('id', '!=', $id)
                ->where('slug', $slug)
                ->withTrashed()
                ->first();
            
            if ($checkSlug) {
                return $this->responseError(__('messages.book.exist'), 400, ErrorCode::PARAM_INVALID);
            }
            
            $imageData = (array) $book->image;
            $removeImage = [];

            if ($request->remove_image) {
                foreach ($request->remove_image as $item) {
                    $key = array_search($item, $imageData);

                    if ($key !== false) {
                        $removeImage[] = str_replace(config('base.aws.s3.url'), '', $item);
                        unset($imageData[$key]);
                    }
                }
            }

            if ($request->image) {
                foreach ($request->image as $file) {
                    $request->file = $file;
                    $imageData[] = config('base.aws.s3.url') . $this->awsS3Service->uploadFile($request, Constant::BOOK_FOLDER);
                }
            }

            if ($removeImage) {
                $this->awsS3Service->removeFile($removeImage);
            }

            $updatedData = [
                'name' => $request->name,
                'slug' => $slug,
                'introduction' => $request->introduction,
                'description' => $request->description,
                'image' => json_encode(array_values($imageData)),
                'price' => (double) $request->price,
                'discount' => (int) $request->discount,
                'is_show' => (int) $request->is_show,
                'discount_price' => (double) ($request->price - (($request->price * ($request->discount / 100)) * 100 / 100))
            ];

            $book->update($updatedData);

            return $this->responseSuccess($book);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function delete($request, $id)
    {
        try {
            $book = $this->book->find($id);
            
            if (!$book) {
                $book = $this->book->withTrashed()->where('id', $id)->first();

                if (!$book) {
                    return $this->responseError(__('messages.book.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $book->restore();
            } else {
                $book->delete();
            }

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function getBooksClient($request)
    {
        try {
            $books = $this->book;

            if (isset($request->name)) {
                $books = $books->where('name', 'like', '%' . $request->name . '%');
            }

            if (isset($request->price_sort)) {
                $books = $books->orderBy('discount_price', $request->price_sort);
            }

            $books = $books->where('is_show', Constant::IS_SHOW)
                ->select([
                    'id',
                    'name',
                    'slug',
                    'introduction',
                    'image',
                    'price',
                    'discount',
                    'discount_price'
                ])
                ->orderByDesc('id');
            $data = $this->pagination($books, $request);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function getBookDetailClient(Request $request)
    {
        try {
            if (!$request->bookSlug) {
                return $this->responseError(__('messages.book.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $book = $this->book->where('slug', $request->bookSlug)
                ->where('is_show', Constant::IS_SHOW)
                ->first();

            if (!$book) {
                return $this->responseError(__('messages.book.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            return $this->responseSuccess($book);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function registerBookClient($request)
    {
        try {
            // $user = auth()->guard('api')->user();
            $book = $this->book->where('slug', $request->bookSlug)
                ->where('is_show', Constant::IS_SHOW)
                ->first();

            if (!$book) {
                return $this->responseError(__('messages.book.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            return $this->responseSuccess($book);
        } catch (\Exception $ex) {
            $this->awsS3Service->removeFile($billingImage);
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
