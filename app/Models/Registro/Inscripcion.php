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
        return $this->belongsTo('App\Models\Registro\CursoProgramado','curso_programado_id','id');
    }

    //Relacion con user
    public function User(){
        return $this->belongsTo('App\User','user_id','id');
    }
}