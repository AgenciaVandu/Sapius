<?php

namespace App\Models\Cursos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Leccion extends Model
{
    protected $table = "lecciones";

    public function Pruebas()
    {
        return $this->hasMany('App\Models\Cursos\Prueba');
    }

    public function Medias()
    {
        return $this->hasMany('App\Models\Cursos\Media');
    }

    public function materialPdfs()
    {
        return $this->hasMany('App\Models\Cursos\MaterialPdf', 'leccion_id');
    }

    public function Curso()
    {
        return $this->belongsTo('App\Models\Cursos\Curso');
    }

    public function Clases()
    {
        return $this->hasMany('App\Models\Cursos\Leccion', 'leccion_id');
    }

    public function userProgress()
    {
        return $this->belongsToMany('App\User', 'leccion_user', 'leccion_id', 'user_id')
            ->withPivot('curso_programado_id', 'completed_at')
            ->withTimestamps();
    }

// protected static function boot()
// {
//     parent::boot();

//     static::addGlobalScope('Activos', function (Builder $builder) {
//         $builder->where('activo', 'si');
//     });
// }
}
