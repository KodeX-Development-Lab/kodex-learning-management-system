<?php
namespace App\Modules\Quiz\Service;

use App\Modules\Quiz\Model\Quiz;

class QuizService
{
    public function createQuiz(array $data)
    {
        return Quiz::create($data);
    }

    public function updateQuiz(Quiz $quiz, array $data)
    {
        $quiz->update($data);
        return $quiz;
    }

    public function deleteQuiz(Quiz $quiz)
    {
        return $quiz->delete();
    }

    public function getAllQuizzes()
    {
        return Quiz::all();
    }

    public function getQuizById($id)
    {
        return Quiz::findOrFail($id);
    }
}
