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

    public function getCourseContent($slug)
    {
        $content = $this->service->getCourseContent($slug);

        return response()->json([
            "status"  => true,
            "data"    => [
                'content' => $content,
            ],
            "message" => "Course COntent",
        ], 200);
    }

    public function enrollCourse($course_id)
    {
        $user = auth()->user();

        if ($this->service->checkAlreadyEnrolled($user, $course_id)) {
            return response()->json([
                "status"  => false,
                "message" => "Already Enrolled",
            ], 400);
        }

        $this->service->enrollCourse($user, $course_id);

        return response()->json([
            "status"  => true,
            "message" => "Enrolled successfully",
        ], 201);
    }
}
