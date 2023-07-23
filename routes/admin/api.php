<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseSectionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'admin.auth'
], function () {
    Route::group([
        'prefix' => 'users'
    ], function () {
        Route::get('', [UserController::class, 'index']);
        Route::put('{id}', [UserController::class, 'update']);
        Route::delete('{id}', [UserController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'courses'
    ], function () {
        Route::get('', [CourseController::class, 'index']);
        Route::post('{id}', [CourseController::class, 'update']);
        Route::delete('{id}', [CourseController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'course-sections'
    ], function () {
        Route::get('', [CourseSectionController::class, 'index']);
        Route::post('{id}', [CourseSectionController::class, 'update']);
        Route::delete('{id}', [CourseSectionController::class, 'delete']);
    });

    Route::group([
        'prefix' => 'videos'
    ], function () {
        Route::get('', [VideoController::class, 'index']);
    });
});
