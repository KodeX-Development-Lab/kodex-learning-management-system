<?php

namespace App\Modules\Course\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFaq extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'course_faqs';
    
    protected $fillable = ['course_id', 'question', 'answer', 'order'];
}
