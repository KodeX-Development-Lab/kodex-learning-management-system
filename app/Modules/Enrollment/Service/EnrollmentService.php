<?php
namespace App\Modules\Enrollment\Service;

use App\Models\Enrollment;

class EnrollmentService
{
    public function createEnrollment(array $data)
    {
        $enrollment = new Enrollment();
        $data['enrollmentID'] = $enrollment->generateUniqueEnrollmentId();
        return Enrollment::create($data);

    }

    public function updateEnrollment(Enrollment $enrollment, array $data)
    {
        $enrollment->update($data);
        return $enrollment;
    }

    public function deleteEnrollment(Enrollment $enrollment)
    {
        return $enrollment->delete();
    }

    public function getAllEnrollments()
    {
        return Enrollment::all();
    }

    public function getEnrollmentById($id)
    {
        return Enrollment::findOrFail($id);
    }
}