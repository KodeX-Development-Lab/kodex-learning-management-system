<?php
namespace App\Modules\Course\Model;

use App\Models\User;
use App\Modules\Categories\Models\Category;
use App\Modules\Languages\Models\Language;
use App\Modules\Storage\Classes\ObjectStorage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title', 'slug', 'user_id', 'category_ids', 'language_ids',
        'what_will_learn', 'requirement', 'description', 'for_whom',
        'thumbnail', 'preview', 'last_updated_at', 'level', 'is_published',
        'useful_links', 'total_time',
    ];

    protected $casts = [
        'category_ids'    => 'array',
        'language_ids'    => 'array',
        'useful_links'    => 'array',
        'preview'         => 'boolean',
        'is_published'    => 'boolean',
        'last_updated_at' => 'datetime',
    ];

    public function getThumbnailAttribute($value)
    {
        $result = null;

        if ($value != null) {
            $result = ObjectStorage::getUrl($value);
        }

        return $result;
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'id', 'category_ids');
    }

    public function languages()
    {
        return $this->hasMany(Language::class, 'id', 'language_ids');
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
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id')->withTimestamps();
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
