<?php

namespace App\Modules\Course\Http\Controller;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Modules\Course\Http\Resources\CourseDetailResource;
use App\Modules\Course\Services\CourseService;
use Illuminate\Http\Request;

class InstructorCourseController extends Controller
{
    protected $service;

    public function __construct(CourseService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        $request->merge([
            'user' => $user->id,
        ]);

        $courses = $this->service->index($request);

        return response()->json([
            "status"  => true,
            "data"    => [
                'courses' => $courses,
            ],
            "message" => "List of Courses",
        ], 200);

    }

    public function show($slug)
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

    public function getStudents($course_id, Request $request)
    {
        $students = $this->service->show($course_id, $request);

        return response()->json([
            "status"  => true,
            "data"    => [
                'students' => $students,
            ],
            "message" => "Student List",
        ], 200);
    }

    public function store(CourseRequest $request)
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

    public function update(CourseUpdateRequest $request, $course)
    {
        $updatedCourse = $this->service->update($request->validated(), $course);

        return response()->json([
            "status"  => true,
            "data"    => [
                'course' => $updatedCourse,
            ],
            "message" => "Course updated successfully",
        ], 200);

    }

    public function destroy($course)
    {
        $this->service->delete($course);

        return response()->json([], 204);
    }
}
