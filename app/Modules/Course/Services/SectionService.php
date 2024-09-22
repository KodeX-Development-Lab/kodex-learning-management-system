<?php
namespace App\Modules\Course\Services;

use App\Modules\Course\Model\Section;
use Illuminate\Support\Str;

class SectionService
{
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
        $section->delete();

        return true;
    }
}
