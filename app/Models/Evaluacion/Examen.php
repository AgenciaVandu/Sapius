<?php

namespace App\Models\Evaluacion;

use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    protected $table = "examenes";
    protected $casts = ['eventos' => 'array'];

    public function Prueba(){
        return $this->belongsTo('App\Models\Cursos\Prueba');
    }

    public function Inscripcion(){
        return $this->belongsTo('App\Models\Registro\Inscripcion');
    }
}
