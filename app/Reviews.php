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

//Relacion uno a uno con el modelo User
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
