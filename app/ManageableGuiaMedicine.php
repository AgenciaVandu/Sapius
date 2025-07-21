<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManageableGuiaMedicine extends Model
{
    protected $fillable = ['image', 'titulo', 'descripcion', 'type', 'category', 'position'];
}