<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCourseSectionRequest;
use App\Http\Requests\UpdateCourseSectionRequest;
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

    public function index(Request $request)
    {
        return $this->courseSectionService->index($request);
    }

    public function create(CreateCourseSectionRequest $request)
    {
        return $this->courseSectionService->create($request);
    }

    public function update(UpdateCourseSectionRequest $request, $id)
    {
        return $this->courseSectionService->update($request, $id);
    }

    public function delete(Request $request, $id)
    {
        return $this->courseSectionService->delete($request, $id);
    }
}
