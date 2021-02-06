<?php

namespace App\Models\Registro;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = "inscripciones";

    public function Inscritos(){
        return $this->hasMany('App\User','id','user_id');
    }

    public function CursoProgramado(){
        return $this->hasOne('App\Models\Registro\CursoProgramado','id','curso_programado_id');
    }
}
