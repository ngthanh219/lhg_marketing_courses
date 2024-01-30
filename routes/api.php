<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookUserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseSectionController;
use App\Http\Controllers\Admin\CourseUserController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Client\AuthController as ClientAuthController;
use App\Http\Controllers\Client\CourseController as ClientCourseController;
use App\Http\Controllers\Client\PostController as ClientPostController;
use App\Http\Controllers\Client\BookController as ClientBookController;
use App\Http\Controllers\Client\BookUserController as ClientBookUserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1'
], function () {
    /**
     * Admin API
     */
    Route::group([
        'prefix' => 'admin'
    ], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::group([
            'middleware' => 'admin.auth'
        ], function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('upload-file', [FileController::class, "uploadFile"]);
            Route::post('remove-file', [FileController::class, "removeFile"]);

            Route::group([
                'prefix' => 'users'
            ], function () {
                Route::get('', [UserController::class, 'index']);
                Route::post('', [UserController::class, 'create']);
                Route::put('{id}', [UserController::class, 'update']);
                Route::delete('{id}', [UserController::class, 'delete']);
            });

            Route::group([
                'prefix' => 'courses'
            ], function () {
                Route::get('', [CourseController::class, 'index']);
                Route::post('', [CourseController::class, 'create']);
                Route::post('{id}', [CourseController::class, 'update']);
                Route::delete('{id}', [CourseController::class, 'delete']);
            });

            Route::group([
                'prefix' => 'course-sections'
            ], function () {
                Route::get('', [CourseSectionController::class, 'index']);
                Route::post('', [CourseSectionController::class, 'create']);
                Route::post('{id}', [CourseSectionController::class, 'update']);
                Route::delete('{id}', [CourseSectionController::class, 'delete']);
            });

            Route::group([
                'prefix' => 'videos'
            ], function () {
                Route::get('', [VideoController::class, 'index']);

                Route::group([
                    'prefix' => 'object'
                ], function () {
                    Route::get('', [VideoController::class, 'getVideoObjectInS3']);
                    Route::post('create-multipart-upload', [VideoController::class, 'createMultipartUpload']);
                    Route::post('sign-multipart-upload', [VideoController::class, 'signMultipartUpload']);
                    Route::post('complete-multipart-upload', [VideoController::class, 'completeMultipartUpload']);
                    Route::post('abort-multipart-upload', [VideoController::class, 'abortMultipartUpload']);
                    Route::post('delete', [VideoController::class, 'deleteObject']);
                });

                Route::post('', [VideoController::class, 'create']);
                Route::put('{id}', [VideoController::class, 'update']);
                Route::delete('{id}', [VideoController::class, 'delete']);
            });

            Route::group([
                'prefix' => 'course-users'
            ], function () {
                Route::get('', [CourseUserController::class, 'index']);
                Route::post('', [CourseUserController::class, 'create']);
                Route::post('{id}', [CourseUserController::class, 'update']);
                Route::delete('{id}', [CourseUserController::class, 'delete']);
            });

            Route::group([
                'prefix' => 'posts'
            ], function () {
                Route::get('', [PostController::class, 'index']);
                Route::post('', [PostController::class, 'create']);
                Route::post('{id}', [PostController::class, 'update']);
                Route::delete('{id}', [PostController::class, 'delete']);
            });

            Route::group([
                'prefix' => 'books'
            ], function () {
                Route::get('', [BookController::class, 'index']);
                Route::post('', [BookController::class, 'create']);
                Route::post('{id}', [BookController::class, 'update']);
                Route::delete('{id}', [BookController::class, 'delete']);
            });

            Route::group([
                'prefix' => 'book-users'
            ], function () {
                Route::get('', [BookUserController::class, 'index']);
                Route::post('{id}', [BookUserController::class, 'update']);
                Route::delete('{id}', [BookUserController::class, 'delete']);
            });
        });
    });

    /**
     * Client API
     */
    Route::post('login', [ClientAuthController::class, 'login'])->middleware('throttle:10,2');
    Route::post('send-verify-code', [ClientAuthController::class, 'sendVerifyCode'])->middleware('throttle:5,1');
    Route::post('register', [ClientAuthController::class, 'register'])->middleware('throttle:10,2');
    Route::post('register-book', [ClientBookUserController::class, 'registerBook'])->middleware('throttle:10,1');
    Route::get('courses', [ClientCourseController::class, 'getCourses']);
    Route::get('courses/{courseSlug}', [ClientCourseController::class, 'getCourseDetail']);
    Route::get('posts', [ClientPostController::class, 'getPosts']);
    Route::get('posts/{postSlug}', [ClientPostController::class, 'getPostDetail']);
    Route::get('books', [ClientBookController::class, 'getBooks']);
    Route::get('books/{bookSlug}', [ClientBookController::class, 'getBookDetail']);

    Route::group([
        'middleware' => 'client.auth'
    ], function () {
        Route::get('info', [ClientAuthController::class, 'getUserInformation']);
        Route::post('register-course', [ClientCourseController::class, 'registerCourse']);
        Route::post('d-v', [ClientCourseController::class, 'decryptVideo']);
    });
});
