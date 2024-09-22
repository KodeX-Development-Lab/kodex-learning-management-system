<?php
namespace App\Modules\Course\Services;

use App\Modules\Course\Model\Lesson;
use App\Modules\Course\Model\Section;
use App\Modules\Storage\Classes\ObjectStorage;
use Illuminate\Support\Str;

class SectionService
{
    private $storage;

    public function index($request)
    {
        $data = Section::with(['lessons'])
            ->withCount(['lessons'])
            ->where('course_id', $request->course_id)
            ->orderBy('order')
            ->get();

        return $data;
    }

    public function show($id)
    {
        return Section::with(['lessons'])->withCount(['lessons'])->findOrFail($id);
    }

    public function store($request)
    {
        $section = Section::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'order'       => $request->order,
        ]);

        return $section;
    }

    public function update($section, $request)
    {
        $section->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'order'       => $request->order,
        ]);

        return $section;
    }

    public function delete($section)
    {
        $this->storage = new ObjectStorage();

        $lessons = Lesson::where('section_id', $section->id)->get();

        foreach ($lessons as $key => $lesson) {
            if ($$lesson->attachment) {
                $this->storage->delete($lesson->attachment);
            }

            $lesson->delete();
        }

        $section->delete();

        return true;
    }
}
