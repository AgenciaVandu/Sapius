<?php

namespace App\Models\Registro;

use Illuminate\Database\Eloquent\Model;

class ContenidoProgramado extends Model
{
    protected $table = "contenidos_programados";

    protected $guarded = ['id'];

    protected $casts = [
        'contenido' => 'array'
    ];
}