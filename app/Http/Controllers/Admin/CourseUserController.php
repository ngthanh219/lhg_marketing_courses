<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCourseUserRequest;
use App\Http\Requests\GetCourseUserRequest;
use App\Http\Requests\UpdateCourseUserRequest;
use App\Services\CourseUserService;
use Illuminate\Http\Request;

class CourseUserController extends Controller
{
    protected $courseUserService;

    public function __construct(
        CourseUserService $courseUserService
    ) {
        $this->courseUserService = $courseUserService;
    }

    public function index(GetCourseUserRequest $request)
    {
        return $this->courseUserService->index($request);
    }

    public function create(CreateCourseUserRequest $request)
    {
        return $this->courseUserService->create($request);
    }

    public function update(UpdateCourseUserRequest $request, $id)
    {
        return $this->courseUserService->update($request, $id);
    }

    public function delete(Request $request, $id)
    {
        return $this->courseUserService->delete($request, $id);
    }
}
