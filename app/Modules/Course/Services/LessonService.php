<?php
namespace App\Modules\Course\Services;

use App\Modules\Course\Model\Lesson;
use App\Modules\Storage\Classes\ObjectStorage;
use Illuminate\Support\Str;

class LessonService
{
    private $storage;

    public function index($request)
    {
        $limit = $request->per_page ? $request->per_page : 10;

    }

    public function show($slug)
    {

    }

    public function get($id)
    {

    }

    public function store($request)
    {
        $attachment = null;

        if ($request->file('attachment')) {
            $this->storage = new ObjectStorage();
            $attachment    = $this->storage->store('attachments', $request->file('attachment'));
        }

        $lesson = Lesson::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'youtube_url' => $request->youtube_url,
            'attachment'  => $attachment,
            'order'       => $request->order,
        ]);

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

        return $lesson;
    }

    public function delete($lesson)
    {
        $lesson->delete();

        if ($$lesson->attachment) {
            $this->storage = new ObjectStorage();
            $this->storage->delete($lesson->attachment);
        }

        return true;
    }
}
