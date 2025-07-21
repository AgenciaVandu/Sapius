<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManageableGuiaNutrition extends Model
{
    protected $fillable = ['image', 'titulo', 'descripcion', 'type', 'category', 'position'];
}