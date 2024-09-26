<?php

namespace App\Modules\LearnerSide\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\LearnerSide\Services\MyLearningService;
use Illuminate\Http\Request;

class MyLearningController extends Controller
{
    protected $service;

    public function __construct(MyLearningService $service)
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

    public function lessonDetail($course_id, $slug)
    {
        $lesson = $this->service->lessonDetail($slug);

        return response()->json([
            "status"  => true,
            "data"    => [
                'lesson' => $lesson,
            ],
            "message" => "Lesson details",
        ], 200);

    }

    public function completeLesson($course_id, $lesson_id)
    {
        $user = auth()->user();
        $this->service->completeLesson($user, $course_id, $lesson_id);

        return response()->json([
            "status"  => true,
            "message" => "Lesson Completed",
        ], 201);
    }
}
