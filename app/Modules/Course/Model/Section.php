<?php
namespace App\Modules\Course\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory, HasUuids;

    protected $table = "sections";

    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'description',
        'order',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'section_id', 'id');
    }

}
