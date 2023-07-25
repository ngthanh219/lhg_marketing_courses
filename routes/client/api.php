<?php

use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\CourseController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->middleware('throttle:10,2');
Route::post('send-verify-code', [AuthController::class, 'sendVerifyCode'])->middleware('throttle:5,1');
Route::post('register', [AuthController::class, 'register'])->middleware('throttle:10,2');
Route::get('courses', [CourseController::class, 'getCourses']);

Route::group([
    'middleware' => 'admin.auth'
], function () {
    
});
