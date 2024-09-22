<?php

namespace App\Modules\Course\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Course\Http\Requests\SectionRequest;
use App\Modules\Course\Model\Section;
use App\Modules\Course\Services\SectionService;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    protected $service;

    public function __construct(SectionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $sections = $this->service->index($request);

        return response()->json([
            "status"  => true,
            "data"    => [
                'sections' => $sections,
            ],
            "message" => "List of Sections",
        ], 200);

    }

    public function show($slug)
    {
        $course = $this->service->show($slug);

        return response()->json([
            "status"  => true,
            "data"    => [
                'course' => $course,
            ],
            "message" => "Section details",
        ], 200);

    }

    public function store(SectionRequest $request)
    {
        $section = $this->service->store($request->validated());

        return response()->json([
            "status"  => true,
            "data"    => [
                'section' => $section,
            ],
            "message" => "Saved successfully",
        ], 201);

    }

    public function update(Section $section, SectionRequest $request)
    {
        $section = $this->service->update($section, $request->validated());

        return response()->json([
            "status"  => true,
            "data"    => [
                'section' => $section,
            ],
            "message" => "Updated successfully",
        ], 200);

    }

    public function destroy(Section $section)
    {
        $section->delete();

        return response()->json([], 204);
    }
}
