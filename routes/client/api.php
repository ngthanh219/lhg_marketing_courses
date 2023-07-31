<?php

use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\CourseController;
use App\Http\Controllers\Client\PostController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,2');
Route::post('send-verify-code', [AuthController::class, 'sendVerifyCode'])->middleware('throttle:5,1');
Route::post('register', [AuthController::class, 'register'])->middleware('throttle:10,2');
Route::get('courses', [CourseController::class, 'getCourses']);
Route::get('courses/{courseSlug}', [CourseController::class, 'getCourseDetail']);
Route::get('posts', [PostController::class, 'getPosts']);
Route::get('posts/{postSlug}', [PostController::class, 'getPostDetail']);

Route::group([
    'middleware' => 'client.auth'
], function () {
    Route::post('register-course', [CourseController::class, 'registerCourse']);
    Route::post('d-v', [CourseController::class, 'decryptVideo']);
});
