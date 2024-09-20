<?php

namespace App\Modules\Instructors\Services;

use App\Modules\Instructors\Enums\InstructorStatus;
use App\Modules\Instructors\Http\Resources\InstructorResource;
use App\Modules\Instructors\Models\InstructorDetail;
use App\Modules\Storage\Classes\ObjectStorage;
use Illuminate\Support\Str;

class InstructorService
{
    public function all($request)
    {
        $keyword  = $request->search ? $request->search : '';
        $per_page = $request->per_page ? $request->per_page : 10;

        $data = InstructorDetail::with(['user:id,name', 'professionalField:id,name', 'certificates'])
            ->where(function ($query) use ($request, $keyword) {
                if ($request->status != null && strtolower($request->status) != 'all') {
                    $query->where('status', $request->status);
                }

                if ($keyword != '') {
                    $query->where('name', 'LIKE', '%' . $request->search . '%');
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

        $items = $data->getCollection();

        $items = collect($items)->map(function ($item) {
            return new InstructorResource($item);
        });

        $data = $data->setCollection($items);

        return $data;
    }

    public function get($id)
    {
        return InstructorDetail::with(['user:id,name', 'professionalField:id,name', 'certificates'])->findOrFail($id);
    }

    public function store($request, $user)
    {
        $instructor_detail = InstructorDetail::create([
            'user_id'                  => $user->id,
            'professional_field_id'    => $request->professional_field_id,
            'work_experience_years'     => $request->work_experience_years,
            'teaching_experience_years' => $request->teaching_experience_years,
            'status'                   => InstructorStatus::PENDING->value,
        ]);

        $certificates = $request->certificates;

        foreach ($certificates as $certificate) {
            $instructor_detail->certificates()->create([
                'title'      => $certificate['title'],
                'attachment' => $certificate['attachment'] ? ObjectStorage::getFilePathFromUrl($certificate['attachment']) : null,
            ]);
        }

        return $instructor_detail;
    }

    public function update($instructor_detail, $request, $user)
    {
        InstructorDetail::where('id', $instructor_detail->id)->update([
            'user_id'                  => $user->id,
            'professional_field_id'    => $request->professional_field_id,
            'work_experience_years'     => $request->work_experience_years,
            'teaching_experience_years' => $request->teaching_experience_years,
            'status'                   => InstructorStatus::PENDING->value,
        ]);

        $certificates = $request->certificates;
        $instructor_detail->certificates()->sync([]);

        foreach ($certificates as $certificate) {
            $instructor_detail->certificates()->create([
                'title'      => $certificate['title'],
                'attachment' => $certificate['attachment'] ? ObjectStorage::getFilePathFromUrl($certificate['attachment']) : null,
            ]);
        }

        return $instructor_detail;
    }
}
