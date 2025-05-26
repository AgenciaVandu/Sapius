<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','slug'];

    protected $appends = ['name_category'];

    public function CursosProgramados(){
        return $this->hasMany('App\Models\Registro\CursoProgramado');
    }

    public function getNameCategoryAttribute(){
        return $this->attributes['name'];
    }
}