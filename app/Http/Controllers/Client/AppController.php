<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function index()
    {
        $env = config('app.env');

        return view('client.app', [
            'env' => $env
        ]);
    }
}
