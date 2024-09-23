<?php

namespace App\Modules\LearnerSide\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Course\Http\Resources\CourseDetailResource;
use App\Modules\LearnerSide\Services\LearnerSideHomeService;
use Illuminate\Http\Request;

class LeanerSideHomeController extends Controller
{
    protected $service;

    public function __construct(LearnerSideHomeService $service)
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
                'course' => new CourseDetailResource($course),
            ],
            "message" => "Course details",
        ], 200);

    }

    public function courseContent($slug)
    {
        $content = $this->service->show($slug);

        return response()->json([
            "status"  => true,
            "data"    => [
                'content' => $content,
            ],
            "message" => "Course COntent",
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
            "message" => "Enrolled successfully",
        ], 201);

    }
}
