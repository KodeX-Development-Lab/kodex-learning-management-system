<?php

namespace App\Modules\Course\Services;

use App\Modules\Course\Model\CourseFaq;

class CourseFaqService
{
    public function index($request)
    {
        $data = CourseFaq::where('course_id', $request->course_id)
            ->orderBy('order')
            ->get();

        return $data;
    }

    public function get($id)
    {
        return CourseFaq::findOrFail($id);
    }

    public function store($request)
    {
        $courseFaq = CourseFaq::create([
            'course_id' => $request->course_id,
            'question'  => $request->question,
            'answer'    => $request->answer,
            'order'     => $request->order ?? 0,
        ]);

        return $courseFaq;
    }

    public function update($courseFaq, $request)
    {
        $courseFaq->update([
            'course_id' => $request->course_id,
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
