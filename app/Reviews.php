<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $fillable = [
        'name',
        'rating',
        'comment',
        'user_id',
        'course_id',
    ];
}
