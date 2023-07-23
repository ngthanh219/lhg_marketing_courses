<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCourseRequest;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(
        CourseService $courseService
    ) {
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {
        return $this->courseService->index($request);
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        return $this->courseService->update($request, $id);
    }

    public function delete(Request $request, $id)
    {
        return $this->courseService->delete($request, $id);
    }
}
