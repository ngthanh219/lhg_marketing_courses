<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(
        BookService $bookService
    ) {
        $this->bookService = $bookService;
    }

    public function getBooks(Request $request)
    {
        return $this->bookService->getBooksClient($request);
    }

    public function getBookDetail(Request $request)
    {
        return $this->bookService->getBookDetailClient($request);
    }
}
