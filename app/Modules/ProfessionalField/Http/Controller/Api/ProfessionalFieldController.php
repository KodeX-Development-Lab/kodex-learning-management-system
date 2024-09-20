<?php

namespace App\Modules\ProfessionalField\Http\Controller\Api;

use App\Http\Controllers\Controller;
use App\Modules\ProfessionalField\Http\Request\ProfessionalFieldRequest;
use App\Modules\ProfessionalField\Models\ProfessionalField;
use App\Modules\ProfessionalField\Services\ProfessionalFieldService;
use Illuminate\Http\Request;

class ProfessionalFieldController extends Controller
{
    private $service;

    public function __construct(ProfessionalFieldService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'professionalField' => $this->service->all($request),
            ],
            'message' => 'Success',
        ], 200);
    }

    public function show(ProfessionalField $professionalField)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'professionalField' => $professionalField,
            ],
            'message' => 'Success',
        ], 201);
    }

    public function store(ProfessionalFieldRequest $request)
    {

        $professionalField = $this->service->store($request);

        return response()->json([
            'status'  => true,
            'data'    => [
                'professionalField' => $professionalField,
            ],
            'message' => 'Successfully saved',
        ], 201);
    }

    public function update(ProfessionalFieldRequest $request, ProfessionalField $professionalField)
    {

        $professionalField = $this->service->update($professionalField, $request);

        return response()->json([
            'status'  => true,
            'data'    => [
                'professionalField' => $professionalField,
            ],
            'message' => 'Successfully updated',
        ], 200);
    }

    public function destroy(ProfessionalField $professionalField)
    {
        $professionalField->delete();

        return response()->json([], 204);
    }
}
