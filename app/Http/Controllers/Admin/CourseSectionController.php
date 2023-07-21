<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CourseSectionService;
use Illuminate\Http\Request;

class CourseSectionController extends Controller
{
    protected $courseSectionService;

    public function __construct(
        CourseSectionService $courseSectionService
    ) {
        $this->courseSectionService = $courseSectionService;
    }

    public function getSectionsByCourse(Request $request, $courseId)
    {
        return $this->courseSectionService->getSectionsByCourse($request, $courseId);
    }
}
