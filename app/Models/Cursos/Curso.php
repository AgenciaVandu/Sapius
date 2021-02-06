<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    public function Lecciones(){
        return $this->hasMany('App\Models\Cursos\Leccion');
    }

    public function CursoProgramado(){
        return $this->hasMany('App\Models\Registro\CursoProgramado');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('Activos', function (Builder $builder) {
    //         $builder->where('activo', 'si');
    //     });
    // }
}
