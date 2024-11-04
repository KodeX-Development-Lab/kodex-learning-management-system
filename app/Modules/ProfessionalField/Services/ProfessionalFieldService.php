<?php

namespace App\Modules\ProfessionalField\Services;

use App\Modules\ProfessionalField\Models\ProfessionalField;
use Illuminate\Support\Str;

class ProfessionalFieldService
{
    public function all($request)
    {
        $keyword  = $request->search ? $request->search : '';
        $per_page = $request->per_page ? $request->per_page : 10;

        $data = ProfessionalField::where(function ($query) use ($keyword) {
            if ($keyword != '') {
                $query->where('name', 'LIKE', "%$keyword%");
            }
        });

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

    public function get($id)
    {
        $professionalField = ProfessionalField::where('id', $id)->first();

        return $professionalField;
    }

    public function store($request)
    {
        $professionalField = ProfessionalField::create([
            'name'        => $request->name,
            'description' => $request->description,
        ]);
        return $professionalField;
    }

    public function update($professionalField, $request)
    {
        $professionalField->name        = $request->name;
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
