<?php
namespace App\Modules\Lesson\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Lesson\Http\Requests\LessonApiRequest;
use App\Modules\Lesson\Model\Lesson;
use App\Services\LessonService;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    protected $lessonService;

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    public function index()
    {
        $lessons = $this->lessonService->getAllLessons();

        return response()->json([
            "status" => true,
            "data" => [
                'lessons' => $lessons,
            ],
            "message" => "List of Lessons",
        ], 200);
    }

    public function show($id)
    {
        $lesson = $this->lessonService->getLessonById($id);

        return response()->json([
            "status" => true,
            "data" => [
                'lesson' => $lesson,
            ],
            "message" => "Lesson details",
        ], 200);
    }

    public function store(LessonApiRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $lesson = $this->lessonService->createLesson($data);

        return response()->json([
            "status" => true,
            "data" => [
                'lesson' => $lesson,
            ],
            "message" => "Lesson created successfully",
        ], 201);
    }

    public function update(LessonApiRequest $request, Lesson $lesson)
    {
        $data = $request->validated();

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $updatedLesson = $this->lessonService->updateLesson($lesson, $data);

        return response()->json([
            "status" => true,
            "data" => [
                'lesson' => $updatedLesson,
            ],
            "message" => "Lesson updated successfully",
        ], 200);
    }

    public function destroy(Lesson $lesson)
    {
        $this->lessonService->deleteLesson($lesson);

        return response()->json([
            "status" => true,
            "data" => null,
            "message" => "Lesson deleted successfully",
        ], 204);
    }
}