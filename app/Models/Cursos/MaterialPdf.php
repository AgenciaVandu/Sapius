<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;

class MaterialPdf extends Model
{
    protected $table = 'material_pdfs';

    protected $fillable = [
        'leccion_id',
        'titulo',
        'file_path',
        'fields_config',
        'allow_download'
    ];

    protected $casts = [
        'fields_config' => 'array',
        'allow_download' => 'boolean'
    ];

    public function leccion()
    {
        return $this->belongsTo('App\Models\Cursos\Leccion', 'leccion_id');
    }

    public function respuestas()
    {
        return $this->hasMany('App\Models\Cursos\AlumnoPdfRespuesta', 'material_pdf_id');
    }
}
