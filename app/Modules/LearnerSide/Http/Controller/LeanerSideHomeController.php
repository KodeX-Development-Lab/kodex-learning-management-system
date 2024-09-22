<?php

namespace App\Modules\LearnerSide\Http\Controller;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseUpdateRequest;
use App\Modules\LeanerSide\Services\LeanerSideHomeService;
use Illuminate\Http\Request;

class LeanerSideHomeController extends Controller
{
    protected $service;

    public function __construct(LeanerSideHomeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $courses = $this->service->index($request);
        return response()->json([
            "status"  => true,
            "data"    => [
                'courses' => $courses,
            ],
            "message" => "List of Courses",
        ], 200);
    }

    public function courseDetail($slug)
    {
        $course = $this->service->show($slug);
        return response()->json([
            "status"  => true,
            "data"    => [
                'course' => $course,
            ],
            "message" => "Course details",
        ], 200);

    }

    public function courseContent($slug)
    {
        $course = $this->service->show($slug);
        return response()->json([
            "status"  => true,
            "data"    => [
                'course' => $course,
            ],
            "message" => "Course details",
        ], 200);

    }

    public function enroll(Request $request)
    {

        $course = $this->service->store($request->validated());
        return response()->json([
            "status"  => true,
            "data"    => [
                'course' => $course,
            ],
            "message" => "Course created successfully",
        ], 201);

    }
}
