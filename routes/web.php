<?php

use App\Http\Controllers\Admin\AppController;
use App\Http\Controllers\Client\AppController as ClientAppController;
use Illuminate\Support\Facades\Route;

Route::get('admin/{path}', [AppController::class, 'index'])->where('path', '(.*)');
Route::get('{path}', [ClientAppController::class, 'index'])->where('path', '(.*)');