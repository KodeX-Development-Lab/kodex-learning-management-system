<?php

namespace App\Modules\CourseFaq\Services;

use App\Modules\Course\Models\CourseFaq;

class CourseFaqService
{
    public function all($request)
    {
        $courseFaq = CourseFaq::when(request('key'), function ($query) {
            $query->orWhere('question', 'like', '%' . request('key') . '%');
            $query->orWhere('answer', 'like', '%' . request('key') . '%');
        });

        return $courseFaq;
    }

    public function get($id)
    {
        $courseFaq = CourseFaq::where('id', $id)->first();

        return $courseFaq;
    }

    public function store($request, $course_id)
    {
        $courseFaq = CourseFaq::create([
            'course_id' => $course_id,
            'question'  => $request->question,
            'answer'    => $request->answer,
            'order'     => $request->order ?? 0,
        ]);
        return $courseFaq;
    }

    public function update($request, $course_id, $courseFaq)
    {
        $courseFaq->update([
            'course_id' => $course_id,
            'question'  => $request->question,
            'answer'    => $request->answer,
            'order'     => $request->order ?? 0,
        ]);
        
        return $courseFaq;
    }

    public function delete($courseFaq)
    {
        $courseFaq->delete();

        return true;
    }
}
