<?php

namespace App\Models;

use App\Modules\Section\Model\Section;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'section_id', 'title', 'slug', 'description', 'attachments',
    ];

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
