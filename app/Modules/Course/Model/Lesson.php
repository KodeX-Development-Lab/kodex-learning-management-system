<?php
namespace App\Modules\Course\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory, HasUuids;

    protected $table = "sections";

    protected $fillable = [
        'section_id',
        'title',
        'slug',
        'description',
        'youtube_url',
        'attachment',
        'order',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function completedUsers()
    {
        return $this->belongsToMany(User::class, 'lesson_user', 'lesson_id', 'user_id')->withTimestamps();
    }

}
