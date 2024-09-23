<?php

namespace App\Modules\LearnerSide\Services;

use App\Modules\Course\Http\Resources\CourseListResource;
use App\Modules\Course\Model\Course;
use Illuminate\Support\Str;

class LearnerSideHomeService
{

    public function index($request)
    {
        $keyword  = $request->search ? $request->search : '';
        $per_page = $request->per_page ? $request->per_page : 10;

        $data = Course::with(['instructor:id,name,profile_image', 'category:id,name', 'language:id,name'])
            ->withCount(['lessons'])
            ->where(function ($query) use ($request, $keyword) {
                if ($request->category != null && strtolower($request->category) != 'all') {
                    $query->where('category_id', $request->category);
                }

                if ($request->language != null && strtolower($request->language) != 'all') {
                    $query->where('language_id', $request->language);
                }

                if ($keyword != '') {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('title', 'LIKE', "%$keyword%")
                            ->orWhere('description', 'LIKE', "%$keyword%")
                            ->orWhere('what_will_learn', 'LIKE', "%$keyword%");
                    });
                }
            })
            ->select('id', 'title', 'description', 'thumbnail', 'total_time')
            ->latest()
            ->paginate($per_page);

        $items = $data->getCollection();

        $items = collect($items)->map(function ($item) {
            return new CourseListResource($item);
        });

        $data = $data->setCollection($items);

        return $data;
    }

    public function show($slug)
    {
        $course = Course::with(['instructor:id,name,profile_image', 'category:id,name', 'language:id,name', 'sections.lessons'])
            ->withCount(['sections', 'lessons'])
            ->where('slug', $slug)
            ->firstOrFail();

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
