<?php

namespace App\Models\Registro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CursoProgramado extends Model
{
    protected $table = "cursos_programados";

    public function instructor(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function Curso(){
        return $this->belongsTo('App\Models\Cursos\Curso');
    }

    public function getPrecioEnMonedaAttribute(){
        //return money_format('%i', (float)$this->attributes['precio']);
        return number_format($this->attributes['precio'], 2);
    }

    public function Inscritos(){
        return $this->belongsToMany('App\User','inscripciones','curso_programado_id','user_id')
                ->withPivot(['created_at','aceptado','id']);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('Activos', function (Builder $builder) {
            $builder->where('activo', 'si');
        });
    }
}
