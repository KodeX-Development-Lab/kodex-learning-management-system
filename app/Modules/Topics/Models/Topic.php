<?php

namespace App\Modules\Topics\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model{

    use HasFactory;
    protected $fillable=['name','description','created_by','updated_by',];
}
