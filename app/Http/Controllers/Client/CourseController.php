<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
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

    public function getCourses(Request $request)
    {
        return $this->courseService->getCoursesClient($request);
    }
}
