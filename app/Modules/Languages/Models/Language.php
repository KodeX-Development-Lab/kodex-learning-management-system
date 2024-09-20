<?php

namespace App\Modules\Languages\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'languages';

    protected $fillable = [
        'name',
        'slug',
        'code',
        'created_by',
        'updated_by',
    ];
}
