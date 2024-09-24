<?php
namespace App\Modules\Course\Model;

use App\Modules\Storage\Classes\ObjectStorage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAttachment extends Model
{
    use HasFactory, HasUuids;

    protected $table = "course_attachments";

    protected $fillable = [
        'course_id',
        'name',
        'file_type',
        'path',
        'size',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function getPathAttribute($value)
    {
        $result = null;

        if ($value != null) {
            $result = ObjectStorage::getUrl($value);
        }

        return $result;
    }

    public function getSizeAttribute($value)
    {
        return (round($value / 1048576, 2) . " MB");
    }
}
