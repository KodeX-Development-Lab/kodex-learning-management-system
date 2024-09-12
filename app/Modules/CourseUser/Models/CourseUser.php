<?php
namespace App\Modules\CourseUser\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model{
   use HasFactory;
   protected $fillable=['course_id','user_id','enrolled_at','is_completed','completed_at'];

}
