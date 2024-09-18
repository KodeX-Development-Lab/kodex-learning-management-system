<?php

namespace App\Modules\Course\Http\Controller;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Modules\Course\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }
    public function index(Request $request)
    {
        $courses = $this->courseService->index($request);
        return response()->json([
            "status" => true,
            "data" => [
                'courses' => $courses,
            ],
            "message" => "List of Courses",
        ], 200);

    }

    public function show($slug)
    {
        $course = $this->courseService->show($slug);
        return response()->json([
            "status" => true,
            "data" => [
                'course' => $course,
            ],
            "message" => "Course details",
        ], 200);

    }

    public function store(CourseRequest $request)
    {

        $course = $this->courseService->store($request->validated());
        return response()->json([
            "status" => true,
            "data" => [
                'course' => $course,
            ],
            "message" => "Course created successfully",
        ], 201);

    }

    public function update(CourseUpdateRequest $request, $course)
    {
        $course = $this->courseService->show($course);
        $updatedCourse = $this->courseService->update($request->validated(), $course);
        return response()->json([
            "status" => true,
            "data" => [
                'course' => $updatedCourse,
            ],
            "message" => "Course updated successfully",
        ], 200);

    }

    public function destroy($course)
    {
        $course = $this->courseService->show($course);

        $this->courseService->delete($course);
        return response()->json([
            "status" => true,
            "data" => null,
            "message" => "Course deleted successfully",
        ], 200);

    }

}
