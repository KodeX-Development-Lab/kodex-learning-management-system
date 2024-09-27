<?php
namespace App\Modules\Course\Services;

use App\Models\User;
use App\Modules\Course\Http\Resources\CourseListResource;
use App\Modules\Course\Model\Course;
use App\Modules\Storage\Classes\ObjectStorage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CourseService
{
    private $storage;

    public function index($request)
    {
        $keyword  = $request->search ? $request->search : '';
        $per_page = $request->per_page ? $request->per_page : 10;

        $data = Course::with(['instructor:id,name,profile_image', 'category:id,name', 'language:id,name', 'topics:id,name'])
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
            ->select('courses.*')
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
        $course = Course::with(['instructor:id,name,profile_image', 'category:id,name', 'language:id,name', 'topics:id,name', 'students:id,name', 'attachments', 'sections.lessons'])
            ->withCount(['lessons', 'students'])
            ->where('slug', $slug)
            ->firstOrFail();

        return $course;
    }

    public function getById($id)
    {
        $course = Course::with(['instructor:id,name,profile_image', 'category:id,name', 'language:id,name', 'topics:id,name', 'students:id,name', 'attachments', 'sections.lessons'])
            ->withCount(['lessons', 'students'])
            ->findOrFail($id);

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

    public function store($request)
    {
        $this->storage = new ObjectStorage();

        $thumbnail = $request->file('thumbnail') ? $this->storage->store('courses/thumbnails', $request->file('thumbnail')) : null;

        $course = Course::create([
            'title'              => $request->title,
            'slug'               => Str::slug($request->title),
            'user_id'            => $request->user_id,
            'category_id'        => $request->category_id,
            'language_id'        => $request->language_id,
            'description'        => $request->description,
            'what_will_learn'    => $request->what_will_learn,
            'requirements'       => $request->requirements,
            'details'            => $request->details,
            'for_whom'           => $request->for_whom,
            'thumbnail'          => $thumbnail,
            'preview_video_url'  => $request->preview_video_url,
            'level'              => $request->level,
            'is_published'       => $request->is_published ? true : false,
            'useful_links'       => $request->useful_links,
            'total_time_minutes' => $request->total_time_minutes,
            'last_updated_at'    => Carbon::now(),
        ]);

        if ($request->topics) {
            $course->topics()->sync($request->topics);
        }

        if ($request->attachments) {
            $attachments = $request->attachments;
            foreach ($attachments as $key => $attachment) {
                $url = $this->storage->store('courses/attachments', $attachment);

                $basename  = $attachment->getClientOriginalName();
                $name      = $basename;
                $file_type = pathinfo($url)['extension'] ?? '';

                $course->attachments()->create([
                    'name'      => $name,
                    'file_type' => $file_type,
                    'path'      => $url,
                    'size'      => $attachment->getSize(),
                ]);
            }
        }

        return $this->getById($course->id);
    }

    public function update($course, $request)
    {
        $old_thumbnail     = $course->thumbnail;
        $has_new_thumbnail = false;

        $thumbnail = $old_thumbnail;

        if ($request->file('thumbnail')) {
            $thumbnail         = ObjectStorage::getFilePathFromUrl($request->thumbnail);
            $has_new_thumbnail = true;
        }

        $course->update([
            'title'              => $request->title,
            'slug'               => Str::slug($request->title),
            // 'user_id'            => $request->user_id,
            'category_id'        => $request->category_id,
            'language_id'        => $request->language_id,
            'description'        => $request->description,
            'what_will_learn'    => $request->what_will_learn,
            'requirements'       => $request->requirements,
            'details'            => $request->details,
            'for_whom'           => $request->for_whom,
            'thumbnail'          => $thumbnail,
            'preview_video_url'  => $request->preview_video_url,
            'level'              => $request->level,
            'is_published'       => $request->is_published ? true : false,
            'useful_links'       => $request->useful_links,
            'total_time_minutes' => $request->total_time_minutes,
            'last_updated_at'    => Carbon::now(),
        ]);

        if ($has_new_thumbnail) {
            $this->storage = new ObjectStorage();
            $this->storage->delete($old_thumbnail);
        }

        if ($request->topics) {
            $course->topics()->sync($request->topics);
        }

        if ($request->attachments) {
            $attachments = $request->attachments;
            foreach ($attachments as $key => $attachment) {
                $url = $this->storage->store('courses/attachments', $attachment);

                $basename  = $attachment->getClientOriginalName();
                $name      = $basename;
                $file_type = pathinfo($url)['extension'] ?? '';

                $course->attachments()->create([
                    'name'      => $name,
                    'file_type' => $file_type,
                    'path'      => $url,
                    'size'      => $attachment->getSize(),
                ]);
            }
        }

        return $this->getById($course->id);
    }

    public static function updateLastUpdatedAtTime($course)
    {
        $course->update([
            'last_updated_at' => Carbon::now(),
        ]);
    }

    public function delete($course)
    {
        $course->delete();

        return true;
    }

}
