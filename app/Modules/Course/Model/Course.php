<?php
namespace App\Modules\Course\Model;

use App\Modules\Categories\Models\Category;
use App\Modules\Languages\Models\Language;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'user_id',
        'what_will_learn',
        'requirement',
        'description',
        'for_whom',
        'thumbnail',
        'preview',
        'total_time',
        'last_updated_at',
        'level',
        'is_published',
        'useful_links',
    ];

    protected $cast = ["category_ids" => 'array', "language_ids" => 'array'];

    public function categories()
    {
        return $this->hasMany(Category::class, 'id', 'category_ids');
    }
    public function languages()
    {
        return $this->hasMany(Language::class, 'id', 'language_ids');
    }

}
