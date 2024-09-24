<?php

namespace App\Services;

use App\Modules\Lesson\Model\Lesson;

class LessonService
{
    public function createLesson(array $data)
    {
        return Lesson::create($data);
    }

    public function updateLesson(Lesson $lesson, array $data)
    {
        $lesson->update($data);
        return $lesson;
    }

    public function deleteLesson(Lesson $lesson)
    {
        return $lesson->delete();
    }

    public function getAllLessons()
    {
        return Lesson::all();
    }

    public function getLessonById($id)
    {
        return Lesson::findOrFail($id);
    }
}