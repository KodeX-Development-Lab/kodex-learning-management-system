<?php

namespace App\Modules\LearnerSide\Services;

use App\Modules\Course\Http\Resources\CourseListResource;
use App\Modules\Course\Model\Course;
use App\Modules\Course\Model\Lesson;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MyLearningService
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

    public function lessonDetail($slug)
    {
        $course = Lesson::with(['section:id,name'])
            ->where('slug', $slug)
            ->firstOrFail();

        return $course;
    }

    public function completeLesson($user, $course_id, $lesson_id)
    {
        $record = DB::table('lesson_user')->where('lesson_id', $lesson_id)->where('user_id', $user->id)->first();

        if ($record) {
            $record->delete();
            return;
        }

        $record = DB::table('lesson_user')->insert([
            'course_id'  => $course_id,
            'lesson_id'  => $lesson_id,
            'user_id'    => $user->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return;
    }
}
