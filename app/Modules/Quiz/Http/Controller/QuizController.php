<?php
namespace App\Modules\Quiz\Http\Controller;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizApiRequest;
use App\Modules\Quiz\Model\Quiz;
use App\Modules\Quiz\Service\QuizService;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function index()
    {
        $quizzes = $this->quizService->getAllQuizzes();

        return response()->json([
            "status" => true,
            "data" => [
                'quizzes' => $quizzes,
            ],
            "message" => "List of Quizzes",
        ], 200);
    }

    public function show($id)
    {
        $quiz = $this->quizService->getQuizById($id);

        return response()->json([
            "status" => true,
            "data" => [
                'quiz' => $quiz,
            ],
            "message" => "Quiz details",
        ], 200);
    }

    public function store(QuizApiRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $quiz = $this->quizService->createQuiz($data);

        return response()->json([
            "status" => true,
            "data" => [
                'quiz' => $quiz,
            ],
            "message" => "Quiz created successfully",
        ], 201);
    }

    public function update(QuizApiRequest $request, Quiz $quiz)
    {
        $data = $request->validated();

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $updatedQuiz = $this->quizService->updateQuiz($quiz, $data);

        return response()->json([
            "status" => true,
            "data" => [
                'quiz' => $updatedQuiz,
            ],
            "message" => "Quiz updated successfully",
        ], 200);
    }

    public function destroy(Quiz $quiz)
    {
        $this->quizService->deleteQuiz($quiz);

        return response()->json([
            "status" => true,
            "data" => null,
            "message" => "Quiz deleted successfully",
        ], 204);
    }
}
