<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgrammingCalendar extends Model
{
    protected $fillable = [
        'curso_id',
        'image_path',
        'start_date',
        'end_date',
        'group_name',
        'position',
    ];

    public function curso()
    {
        return $this->belongsTo('App\Models\Cursos\Curso', 'curso_id');
    }
}
