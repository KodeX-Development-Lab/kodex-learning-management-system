<?php

namespace App\Modules\Instructors\Models;

use App\Models\User;
use App\Modules\Instructors\Enums\InstructorStatus;
use App\Modules\ProfessionalField\Models\ProfessionalField;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorDetail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'instructor_details';

    protected $fillable = [
        'user_id',
        'professional_field_id',
        'work_experience_year',
        'teaching_experience_year',
        'status',
        'acted_by',
        'acted_at',
    ];

    protected $appends = ['approve_option', 'reject_option'];

    public function getApproveOptionAttribute()
    {
        if ($this->status == InstructorStatus::PENDING->value) {
            return true;
        }

        return false;
    }

    public function getRejectOptionAttribute()
    {
        if ($this->status == InstructorStatus::PENDING->value) {
            return true;
        }

        return false;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function professionalField()
    {
        return $this->belongsTo(ProfessionalField::class, 'professional_field_id');
    }

    public function certificates()
    {
        return $this->hasMany(InstructorCertificate::class, 'instructor_detail_id');
    }
}
