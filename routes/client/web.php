<?php

use App\Http\Controllers\Client\AppController;
use Illuminate\Support\Facades\Route;

Route::get('{path}', [AppController::class, 'index'])->where('path', '(.*)');
