<?php

namespace App\Modules\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseFaq extends Model{
    use HasFactory;
    protected $fillable=['course_id','question','answer'];
}
