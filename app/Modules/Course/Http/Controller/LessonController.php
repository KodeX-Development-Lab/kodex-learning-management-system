<?php

namespace App\Modules\Course\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Course\Http\Requests\LessonRequest;
use App\Modules\Course\Model\Lesson;
use App\Modules\Course\Services\LessonService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    protected $service;

    public function __construct(LessonService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $lessons = $this->service->index($request);

        return response()->json([
            "status"  => true,
            "data"    => [
                'lessons' => $lessons,
            ],
            "message" => "List of lessons",
        ], 200);

    }

    public function show($course_id, $section_id, $lesson)
    {
        $lesson = $this->service->show($lesson);

        return response()->json([
            "status"  => true,
            "data"    => [
                'lesson' => $lesson,
            ],
            "message" => "Lesson details",
        ], 200);

    }

    public function store(LessonRequest $request)
    {
        $lesson = $this->service->store($request);

        return response()->json([
            "status"  => true,
            "data"    => [
                'lesson' => $lesson,
            ],
            "message" => "Saved successfully",
        ], 201);

    }

    public function update($course_id, $section_id, Lesson $lesson, LessonRequest $request)
    {
        $lesson = $this->service->update($lesson, $request->validated());

        return response()->json([
            "status"  => true,
            "data"    => [
                'lesson' => $lesson,
            ],
            "message" => "Updated successfully",
        ], 200);

    }

    public function destroy(Lesson $lesson)
    {
        $this->service->delete($lesson);

        return response()->json([], 204);
    }

}
