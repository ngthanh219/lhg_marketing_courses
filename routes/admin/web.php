<?php

use App\Http\Controllers\Admin\AppController;
use Illuminate\Support\Facades\Route;

Route::get('admin/{path}', [AppController::class, 'index'])->where('path', '(.*)');
