<?php

namespace App\Modules\ProfessionalField\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalField extends Model
{
    use HasFactory, HasUuids, Sluggable;

    protected $table = 'professional_fields';

    protected $fillable = ['name', 'slug', 'description'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
}
