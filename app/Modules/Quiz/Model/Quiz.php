<?php
namespace App\Modules\Quiz\Model;

use App\Models\User;
use App\Modules\Section\Model\Section;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['section_id', 'title', 'question', 'slug', 'provided_answer', 'answer'];

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
