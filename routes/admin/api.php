<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'admin.auth'
], function () {
    Route::group([
        'prefix' => 'users'
    ], function () {
        Route::get('', [UserController::class, 'index']);
    });
});
