<?php

namespace App\Modules\Enrollment\Models;

use App\Modules\Course\Model\Course;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['course_id', 'user_id', 'enrolled_at', 'is_completed', 'completed_at'];

    public function student()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollmentIdExists($id)
    {
        return Enrollment::where('enrollmentID', 'ER-' . $id)->exists();
    }

    public function generateUniqueEnrollmentId()
    {
        do {
            $id = mt_rand(10000000000, 99999999999);
        } while ($this->enrollmentIdExists($id));

        return 'ER-' . $id;
    }

}
