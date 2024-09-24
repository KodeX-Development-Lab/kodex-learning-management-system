<?php
namespace App\Modules\Section\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Section\Http\Requests\SectionApiRequest;
use App\Modules\Section\Model\Section;
use App\Modules\Section\Service\SectionService;
use Illuminate\Support\Str;

class SectionController extends Controller
{

    protected $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;
    }

    public function index()
    {
        $sections = $this->sectionService->getAllSections();
        return response()->json([
            "status" => true,
            "data" => [
                'sections' => $sections,
            ],
            "message" => "List of Sections",
        ], 200);

    }

    public function show($id)
    {
        $section = $this->sectionService->getSectionById($id);

        return response()->json([
            "status" => true,
            "data" => [
                'section' => $section,
            ],
            "message" => "Section details",
        ], 200);

    }

    public function store(SectionApiRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $section = $this->sectionService->createSection($data);

        return response()->json([
            "status" => true,
            "data" => [
                'section' => $section,
            ],
            "message" => "Section created successfully",
        ], 201);
    }

    public function update(SectionApiRequest $request, Section $section)
    {
        $data = $request->validated();

        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        $updatedSection = $this->sectionService->updateSection($section, $data);

        return response()->json([
            "status" => true,
            "data" => [
                'section' => $updatedSection,
            ],
            "message" => "Section updated successfully",
        ], 200);
    }

    public function destroy(Section $section)
    {
        $this->sectionService->deleteSection($section);

        return response()->json([
            "status" => true,
            "data" => null,
            "message" => "Section deleted successfully",
        ], 204);
    }
}
