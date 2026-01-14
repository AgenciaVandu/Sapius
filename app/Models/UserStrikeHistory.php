<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStrikeHistory extends Model
{
    protected $fillable = ['user_id', 'action', 'details'];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
