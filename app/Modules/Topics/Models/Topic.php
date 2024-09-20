<?php

namespace App\Modules\Topics\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'topics';

    protected $fillable = ['name', 'slug', 'description', 'created_by', 'updated_by'];
}
