<?php

namespace App\Models\Registro;

use Illuminate\Database\Eloquent\Model;

class LessonUnlock extends Model
{
    protected $table = 'lesson_unlocks';

    protected $fillable = [
        'user_id',
        'curso_programado_id',
        'leccion_id',
        'until_date',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function cursoProgramado()
    {
        return $this->belongsTo(CursoProgramado::class);
    }

    public function leccion()
    {
        return $this->belongsTo(\App\Models\Cursos\Leccion::class);
    }
}
