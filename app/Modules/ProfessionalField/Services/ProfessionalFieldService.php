<?php

namespace App\Modules\ProfessionalField\Services;

use App\Modules\ProfessionalField\Models\ProfessionalField;
use Illuminate\Support\Str;

class ProfessionalFieldService
{
    public function all($request)
    {
        $keyword = $request->search ? $request->search : '';
        $limit   = $request->limit ? $request->limit : 10;

        $topics = ProfessionalField::where(function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%$keyword%");
        })
            ->paginate($limit);

        return $topics;
    }

    public function get($id)
    {
        $professionalField = ProfessionalField::where('id', $id)->first();

        return $professionalField;
    }

    public function store($request)
    {
        $professionalField = ProfessionalField::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);
        return $professionalField;
    }

    public function update($professionalField, $request)
    {
        $professionalField->name        = $request->name;
        $professionalField->slug        = Str::slug($request->name);
        $professionalField->description = $request->description;
        $professionalField->save();
        return $professionalField;
    }

    public function delete($professionalField)
    {
        $professionalField->delete();

        return true;
    }
}
