<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    public function Preguntas(){
        return $this->hasMany('App\Models\Cursos\Pregunta');
    }

    public function Leccion(){
        return $this->belongsTo('App\Models\Cursos\Leccion');
    }

    public function Examenes(){
        return $this->hasMany('App\Models\Evaluacion\Examen');
    }
}
