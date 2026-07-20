<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class AlumnoPdfRespuesta extends Model
{
    protected $table = 'alumno_pdf_respuestas';

    protected $fillable = [
        'user_id',
        'material_pdf_id',
        'respuestas'
    ];

    protected $casts = [
        'respuestas' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function materialPdf()
    {
        return $this->belongsTo('App\Models\Cursos\MaterialPdf', 'material_pdf_id');
    }
}
