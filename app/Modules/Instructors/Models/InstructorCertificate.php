<?php

namespace App\Modules\Instructors\Models;

use App\Modules\Storage\Classes\ObjectStorage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorCertificate extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'instructor_certificates';

    protected $fillable = [
        'instructor_detail_id',
        'title',
        'attachment',
    ];

    public function getAttachmentAttribute($value)
    {
        if ($value != null) {
            return ObjectStorage::getUrl($value);
        }

        return null;
    }

    public function instructorDetail()
    {
        return $this->belongsTo(InstructorDetail::class, 'instructor_detail_id');
    }
}
