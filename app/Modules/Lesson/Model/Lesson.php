<?php
namespace App\Modules\Lesson\Model;

use App\Models\User;
use App\Modules\Section\Model\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['section_id', 'title', 'slug', 'description', 'youtube_url', 'attachments'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }
    public function students()
    {
        return $this->hasMany(User::class);
    }
}