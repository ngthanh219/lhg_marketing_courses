<?php

namespace App\Services;

use App\Helpers\GeneralHelper;
use App\Libraries\Constant;
use App\Libraries\ErrorCode;
use App\Models\Book;
use App\Models\BookUser;
use App\Models\User;

class BookUserService extends BaseService
{
    protected $user;
    protected $book;
    protected $bookUser;
    protected $awsS3Service;

    public function __construct(
        User $user,
        Book $book,
        BookUser $bookUser,
        AWSS3Service $awsS3Service
    ) {
        $this->user = $user;
        $this->book = $book;
        $this->bookUser = $bookUser;
        $this->awsS3Service = $awsS3Service;
    }

    public function index($request)
    {
        try {
            $bookUsers = $this->bookUser->with('book:id,name');

            if (isset($request->status_sort)) {
                $bookUsers = $bookUsers->orderBy('status', $request->status_sort);
            }

            if (isset($request->id_sort)) {
                $bookUsers = $bookUsers->orderBy('id', $request->id_sort);
            }

            if (isset($request->is_deleted)) {
                if ($request->is_deleted == Constant::IS_DELETED) {
                    $bookUsers = $bookUsers->onlyTrashed();
                }
            }

            $data = $this->pagination($bookUsers, $request);

            return $this->responseSuccess($data);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function update($request, $id)
    {
        try {
            $bookUser = $this->bookUser->find($id);
            if (!$bookUser) {
                return $this->responseError(__('messages.book_user.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }

            $bookUser->update([
                'status' => (int) $request->status
            ]);

            return $this->responseSuccess($bookUser);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function delete($request, $id)
    {
        try {
            $bookUser = $this->bookUser->find($id);
            
            if (!$bookUser) {
                $bookUser = $this->bookUser->withTrashed()->where('id', $id)->first();

                if (!$bookUser) {
                    return $this->responseError(__('messages.book_user.not_exist'), 400, ErrorCode::PARAM_INVALID);
                }

                $bookUser->restore();
            } else {
                $bookUser->delete();
            }

            return $this->responseSuccess();
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }

    public function registerBook($request)
    {
        try {
            $user = auth()->guard('api')->user();
            $book = $this->book->find($request->book_id);

            if (!$book) {
                return $this->responseError(__('messages.book.not_exist'), 400, ErrorCode::PARAM_INVALID);
            }
            
            $data = [
                'user_id' => null,
                'other_name' => $request->name,
                'other_email' => $request->email,
                'other_phone' => $request->phone,
                'note' => $request->note,
                'book_id' => $book->id,
                'price' => $book->price,
                'discount' => $book->discount,
                'discount_price' => $book->discount_price,
            ];

            if ($user) {
                $data['user_id'] = $user->id;
                $existBookUser = $this->bookUser->where('user_id', $user->id)
                    ->where('book_id', $book->id)
                    ->first();
            } else {
                $existBookUser = $this->bookUser->where('book_id', $book->id)
                    ->where(function ($query) use ($request) {
                        $query->Where('other_email', $request->email)
                            ->orWhere('other_phone', $request->phone);
                    })->first();
            }

            if ($existBookUser) {
                return $this->responseError(__('messages.book_user.registered_user'), 400, ErrorCode::PARAM_INVALID);
            }

            $bookUser = $this->bookUser->create($data);

            return $this->responseSuccess($bookUser);
        } catch (\Exception $ex) {
            GeneralHelper::detachException(__CLASS__ . '::' . __FUNCTION__, 'Try catch', $ex->getMessage());

            return $this->responseError(__('messages.system.server_error'), 500, ErrorCode::SERVER_ERROR);
        }
    }
}
