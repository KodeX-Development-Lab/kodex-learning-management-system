<?php
namespace App\Modules\Course\Services;

use App\Modules\Course\Model\Course;
use App\Modules\Course\Model\Lesson;
use App\Modules\Storage\Classes\ObjectStorage;
use Illuminate\Support\Str;

class LessonService
{
    private $storage;

    public function index($request)
    {
        $data = Lesson::with(['section'])
            ->where('section_id', $request->section_id)
            ->orderBy('order')
            ->get();

        return $data;
    }

    public function show($id)
    {
        return Lesson::with(['section'])->findOrFail($id);
    }

    public function store($request)
    {
        $attachment = null;

        if ($request->file('attachment')) {
            $this->storage = new ObjectStorage();
            $attachment    = $this->storage->store('attachments', $request->file('attachment'));
        }

        $lesson = Lesson::create([
            'section_id'  => $request->section_id,
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'youtube_url' => $request->youtube_url,
            'attachment'  => $attachment,
            'order'       => $request->order,
        ]);

        $course = Course::findOrFail($request->course_id);
        CourseService::updateLastUpdatedAtTime($course);

        return $lesson;
    }

    public function update($lesson, $request)
    {
        $old_attachment = $lesson->attachment ? $lesson->attachment : null;

        $new_attachment = $old_attachment;
        $this->storage  = new ObjectStorage();

        if ($request->file('attachment')) {
            $new_attachment = $this->storage->store('attachments', $request->file('attachment'));
        }

        $lesson->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'youtube_url' => $request->youtube_url,
            'attachment'  => $new_attachment,
            'order'       => $request->order,
        ]);

        if ($old_attachment != $new_attachment) {
            $this->storage->delete($old_attachment);
        }

        $course = Course::findOrFail($request->course_id);
        CourseService::updateLastUpdatedAtTime($course);

        return $lesson;
    }

    public function delete($lesson)
    {
        $lesson->delete();

        if ($$lesson->attachment) {
            $this->storage = new ObjectStorage();
            $this->storage->delete($lesson->attachment);
        }

        $course = Course::findOrFail($request->course_id);
        CourseService::updateLastUpdatedAtTime($course);

        return true;
    }
}
