<?php
namespace App\Modules\Section\Model;

use App\Models\Assignment;
use App\Modules\Course\Model\Course;
use App\Modules\Lesson\Model\Lesson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['course_id', 'title', 'description', 'slug'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
    public function quizes()
    {
        return $this->hasMany(Lesson::class);
    }
}