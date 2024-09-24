<?php
namespace App\Modules\Course\Services;

use App\Models\User;
use App\Modules\Course\Http\Resources\CourseListResource;
use App\Modules\Course\Model\Course;
use Illuminate\Support\Str;

class CourseService
{

    public function index($request)
    {
        $keyword  = $request->search ? $request->search : '';
        $per_page = $request->per_page ? $request->per_page : 10;

        $data = Course::with(['instructor:id,name,profile_image', 'category:id,name', 'language:id,name'])
            ->withCount(['lessons', 'students'])
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

    public function getStudents($course_id, $request)
    {
        $keyword  = $request->search ? $request->search : '';
        $per_page = $request->per_page ? $request->per_page : 10;

        $data = User::join('enrollments', 'enrollments.user_id', 'users.id')
            ->where('enrollments.course_id', $course_id)
            ->where(function ($query) use ($request, $keyword) {
                if ($keyword != '') {
                    $query->where('users.name', 'LIKE', "%$keyword%");
                }
            })
            ->groupBy('users.id')
            ->select('users.id', 'users.name', 'enrollments.enrolled_at', 'enrollments.completed_at');

        if ($request->sort != null && $request->sort != '') {
            $sorts = explode(',', $request->input('sort', ''));

            foreach ($sorts as $sortColumn) {
                $sortDirection = Str::startsWith($sortColumn, '-') ? 'DESC' : 'ASC';
                $sortColumn    = ltrim($sortColumn, '-');

                $data->orderBy($sortColumn, $sortDirection);
            }
        } else {
            $data->orderBy('created_at', 'DESC');
        }

        $data = $data->paginate($per_page);

        return $data;
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

        $course->update($validated);
        return $course;
    }

    public function delete($course)
    {
        $course->delete();

        return true;
    }

}
