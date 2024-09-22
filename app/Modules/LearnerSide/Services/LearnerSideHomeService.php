<?php

namespace App\Modules\LearnerSide\Services;

use App\Modules\Course\Model\Course;
use Illuminate\Support\Str;

class LearnerSideHomeService
{

    public function index($request)
    {
        $limit = $request->limit ? $request->limit : 10;

        $courses = Course::latest()
            ->filter($request->search)
            ->paginate($limit)
            ->withQueryString();
        return $courses;
    }

    public function show($slug)
    {
        $course = Course::where('slug', $slug)->first();
        return $course;
    }
    public function get($id)
    {
        $course = Course::firstOrFail($id);
        return $course;
    }

    public function store($validated)
    {
        $validated['user_id'] = auth()->id();

        $course = Course::create($validated);

        return $course;
    }

    public function update($validated, $course)
    {

        $validated['user_id'] = auth()->id();
        $validated['slug']    = Str::slug($validated['title']);

        // dd($validated['slug']);

        $course->update($validated);
        return $course;
    }

    public function delete($course)
    {
        $course->delete();

        return true;
    }

}
