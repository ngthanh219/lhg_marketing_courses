<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function index()
    {
        $env = config('app.env');

        return view('admin.app', [  
            'env' => $env
        ]);
    }
}
