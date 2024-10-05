<?php
namespace App\Modules\Course\Model;

use App\Models\User;
use App\Modules\Categories\Models\Category;
use App\Modules\Languages\Models\Language;
use App\Modules\Storage\Classes\ObjectStorage;
use App\Modules\Topics\Models\Topic;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Course extends Model
{
    use HasFactory, HasUuids, Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'category_id',
        'language_id',
        'description',
        'what_will_learn',
        'requirements',
        'details',
        'for_whom',
        'thumbnail',
        'preview_video_url',
        'level',
        'is_published',
        'useful_links',
        'total_time_minutes',
        'last_updated_at',
    ];

    protected $casts = [
        'useful_links' => 'array',
        'is_published' => 'boolean',
    ];

    protected $appends = ['total_time_minutes_text'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getThumbnailAttribute($value)
    {
        $result = null;

        if ($value != null) {
            $result = ObjectStorage::getUrl($value);
        }

        return $result;
    }

    public function getTotalTimeMinutesTextAttribute()
    {
        if ($this->total_time_minutes == 0) {
            return "0 min";
        }

        $hours   = floor($this->total_time_minutes / 60);
        $minutes = $this->total_time_minutes % 60;

        return $hours . "h " . ($minutes < 9 ? "0$minutes" : $minutes) . "min";
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'course_topic', 'course_id', 'topic_id')->withTimestamps();
    }

    public function attachments()
    {
        return $this->hasMany(CourseAttachment::class, 'course_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'course_id', 'id');
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')->withTimestamps();
    }

    public function scopeFilter($query, $filter)
    {
        $query->when($filter['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        });
    }

}
