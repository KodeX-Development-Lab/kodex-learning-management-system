<?php
namespace App\Modules\Enrollment\Http\Controller;

use App\Models\Enrollment;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollmentApiRequest;
use App\Modules\Enrollment\Service\EnrollmentService;

class EnrollmentController extends Controller
{
     protected $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    public function index()
    {
        $enrollments = $this->enrollmentService->getAllEnrollments();

        return response()->json([
            "status" => true,
            "data" => [
                'enrollments' => $enrollments,
            ],
            "message" => "List of Enrollments",
        ], 200);
    }

    public function show($id)
    {
        $enrollment = $this->enrollmentService->getEnrollmentById($id);

        return response()->json([
            "status" => true,
            "data" => [
                'enrollment' => $enrollment,
            ],
            "message" => "Enrollment details",
        ], 200);
    }

    public function store(EnrollmentApiRequest $request)
    {
        $data = $request->validated();

        $enrollment = $this->enrollmentService->createEnrollment($data);

        return response()->json([
            "status" => true,
            "data" => [
                'enrollment' => $enrollment,
            ],
            "message" => "Enrollment created successfully",
        ], 201);
    }

    public function update(EnrollmentApiRequest $request, Enrollment $enrollment)
    {
        $data = $request->validated();

        $updatedEnrollment = $this->enrollmentService->updateEnrollment($enrollment, $data);

        return response()->json([
            "status" => true,
            "data" => [
                'enrollment' => $updatedEnrollment,
            ],
            "message" => "Enrollment updated successfully",
        ], 200);
    }

    public function destroy(Enrollment $enrollment)
    {
        $this->enrollmentService->deleteEnrollment($enrollment);

        return response()->json([
            "status" => true,
            "data" => null,
            "message" => "Enrollment deleted successfully",
        ], 204);
    }
}