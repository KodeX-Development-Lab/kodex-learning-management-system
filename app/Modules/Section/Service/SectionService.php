<?php
namespace App\Modules\Section\Service;

use App\Modules\Section\Model\Section;

class SectionService
{
    public function createSection(array $data)
    {
        return Section::create($data);
    }

    public function updateSection(Section $section, array $data)
    {
        $section->update($data);
        return $section;
    }

    public function deleteSection(Section $section)
    {
        return $section->delete();
    }

    public function getAllSections()
    {
        return Section::all();
    }

    public function getSectionById($id)
    {
        return Section::findOrFail($id);
    }
}