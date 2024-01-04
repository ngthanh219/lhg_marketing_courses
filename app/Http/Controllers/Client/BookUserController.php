<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterBookRequest;
use App\Services\BookUserService;
use Illuminate\Http\Request;

class BookUserController extends Controller
{
    protected $bookUserService;

    public function __construct(
        BookUserService $bookUserService
    ) {
        $this->bookUserService = $bookUserService;
    }

    public function registerBook(RegisterBookRequest $request)
    {
        return $this->bookUserService->registerBook($request);
    }
}
