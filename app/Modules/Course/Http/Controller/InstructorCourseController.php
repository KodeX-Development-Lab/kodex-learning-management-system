<?php

namespace App\Modules\Course\Http\Controller;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Modules\Course\Http\Resources\CourseDetailResource;
use App\Modules\Course\Model\Course;
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
        $students = $this->service->getStudents($course_id, $request);

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
        $user = auth()->user();

        $request->merge([
            'user_id' => $user->id,
        ]);

        $course = $this->service->store($request);

        return response()->json([
            "status"  => true,
            "data"    => [
                'course' => new CourseDetailResource($course),
            ],
            "message" => "Course created successfully",
        ], 201);

    }

    public function update(Course $course, CourseRequest $request)
    {
        $course = $this->service->update($course, $request);

        return response()->json([
            "status"  => true,
            "data"    => [
                'course' => new CourseDetailResource($course),
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
