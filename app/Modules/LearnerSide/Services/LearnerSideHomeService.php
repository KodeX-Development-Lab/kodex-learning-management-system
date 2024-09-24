<?php

namespace App\Modules\LearnerSide\Services;

use App\Modules\Course\Http\Resources\CourseContentResource;
use App\Modules\Course\Http\Resources\CourseListResource;
use App\Modules\Course\Model\Course;
use App\Modules\Course\Model\Section;
use Illuminate\Support\Facades\DB;

class LearnerSideHomeService
{
    public function index($request)
    {
        $keyword  = $request->search ? $request->search : '';
        $per_page = $request->per_page ? $request->per_page : 10;

        $data = Course::with(['instructor:id,name,profile_image', 'category:id,name', 'language:id,name'])
            ->withCount(['sections', 'lessons', 'students'])
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
        $course = Course::with(['instructor:id,name,profile_image', 'category:id,name', 'language:id,name', 'students:id,name', 'sections.lessons'])
            ->withCount(['sections', 'lessons', 'students'])
            ->where('slug', $slug)
            ->firstOrFail();

        return $course;
    }

    public function getCourseContent($slug)
    {
        $sections = Section::with([
            'lessons' => function ($query) {
                $query->with(['completedUsers:id,name'])->select('lessons.*');
            },
        ])
            ->join('courses', 'courses.id', 'sections.course_id')
            ->where('courses.slug', $slug)
            ->select('sections.*')
            ->groupBy('sections.id')
            ->get();

        return CourseContentResource::collection($sections);
    }

    public function checkAlreadyEnrolled($user, $course_id)
    {
        return DB::table('enrollments')->where('course_id', $course_id)->where('user_id', $user->id)->first();
    }

    public function enrollCourse($user, $course_id)
    {
        DB::table('enrollments')->insert([
            'course_id' => $course_id,
            'user_id'   => $user->id,
        ]);

        return;
    }
}
