<?php
namespace App\Modules\Course\Model;

use App\Models\User;
use App\Modules\Storage\Classes\ObjectStorage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory, HasUuids;

    protected $table = "lessons";

    protected $fillable = [
        'section_id',
        'title',
        'slug',
        'description',
        'youtube_url',
        'attachment',
        'order',
    ];

    public function getAttachmentAttribute($value)
    {
        $result = null;

        if ($value != null) {
            $result = ObjectStorage::getUrl($value);
        }

        return $result;
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function completedUsers()
    {
        return $this->belongsToMany(User::class, 'lesson_user', 'lesson_id', 'user_id')->withTimestamps();
    }

}
