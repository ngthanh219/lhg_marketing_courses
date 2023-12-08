<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
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

    public function index(Request $request)
    {
        return $this->bookService->index($request);
    }

    public function create(CreateBookRequest $request)
    {
        return $this->bookService->create($request);
    }

    public function update(UpdateBookRequest $request, $id)
    {
        return $this->bookService->update($request, $id);
    }

    public function delete(Request $request, $id)
    {
        return $this->bookService->delete($request, $id);
    }
}
