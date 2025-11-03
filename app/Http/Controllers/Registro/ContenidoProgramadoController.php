<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cursos\Curso;
use App\Models\Registro\CursoProgramado;
use App\Models\Registro\ContenidoProgramado;

class ContenidoProgramadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $curso = CursoProgramado::with(['Curso.Lecciones.Clases'])->find($request->cp_id);
        $contenido_programado = ContenidoProgramado::where('curso_programado_id',$request->cp_id)->first();
        $curso_original = Curso::find($curso->curso_id);

        if ($contenido_programado) {
            $contenido = collect($contenido_programado->contenido);

            // Ordenar módulos
            $modulos = $curso->Curso->Lecciones->filter(fn($m) => $m->leccion_id == 0)
                ->sortBy(fn($modulo) => $contenido->firstWhere('id', $modulo->id)['orden'] ?? 0)
                ->values(); // Reindexa colección

            // Ordenar clases dentro de cada módulo
            $modulos->transform(function($modulo) use ($contenido) {
                $modulo->Clases = $modulo->Clases->sortBy(fn($clase) => $contenido->firstWhere('id', $clase->id)['orden'] ?? 0)->values();
                return $modulo;
            });

            // Reemplazar la relación original para que la vista use la colección ordenada
            $curso->Curso->Lecciones = $modulos;
        }

        return view('registro.index-contenido')
                ->with('cp', $curso)
                ->with('contenido_programado', $contenido_programado)
                ->with('curso_original', $curso_original)
                ->with('curso', $curso)
                ->with('curso_programado', $curso);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
        // Traer curso y lecciones
        $curso = Curso::with('Lecciones.Clases')->find($request->curso_id);

        // Traer o crear contenido programado
        $contenido_programado = ContenidoProgramado::firstOrNew([
            'curso_programado_id' => $request->curso_programado_id
        ]);

        $arr = [];

        foreach ($curso->Lecciones as $leccion) {
            $arr[] = [
                'id' => $request->{'leccion_id_'.$leccion->id},
                'orden' => $request->{'orden_'.$leccion->id} ?? 0,
                'fecha_inicial' => $request->{'fecha_inicial_'.$leccion->id},
                'fecha_final' => $request->{'fecha_final_'.$leccion->id},
                'hora_inicial' => $request->{'hora_inicial_'.$leccion->id},
                'hora_final' => $request->{'hora_final_'.$leccion->id},
            ];

            // Agregar clases dentro de la lección
            foreach ($leccion->Clases as $clase) {
                $arr[] = [
                    'id' => $request->{'leccion_id_'.$clase->id},
                    'orden' => $request->{'orden_'.$clase->id} ?? 0,
                    'fecha_inicial' => $request->{'fecha_inicial_'.$clase->id},
                    'fecha_final' => $request->{'fecha_final_'.$clase->id},
                    'hora_inicial' => $request->{'hora_inicial_'.$clase->id},
                    'hora_final' => $request->{'hora_final_'.$clase->id},
                ];
            }
        }

        $contenido_programado->contenido = $arr;
        $contenido_programado->save();

        // Traer curso programado con lecciones y clases
        $cp = CursoProgramado::with('Curso.Lecciones.Clases')->find($request->curso_programado_id);
        $curso_original = Curso::find($cp->curso_id);

        // Reordenar módulos y clases según el JSON guardado
        if ($contenido_programado) {
            $contenido = collect($contenido_programado->contenido);

            // Ordenar módulos principales
            $modulos = $cp->Curso->Lecciones->filter(fn($m) => $m->leccion_id == 0)
                ->sortBy(fn($modulo) => $contenido->firstWhere('id', $modulo->id)['orden'] ?? 0)
                ->values();

            // Ordenar clases dentro de cada módulo
            $modulos->transform(function($modulo) use ($contenido) {
                $modulo->Clases = $modulo->Clases->sortBy(fn($clase) => $contenido->firstWhere('id', $clase->id)['orden'] ?? 0)
                                                ->values();
                return $modulo;
            });

            // Reemplazar relación original para que la vista reciba el orden correcto
            $cp->Curso->Lecciones = $modulos;
        }

        return view('registro.index-contenido')
            ->with('cp', $cp)
            ->with('contenido_programado', $contenido_programado)
            ->with('curso_original', $curso_original)
            ->with('curso', $cp)
            ->with('curso_programado', $cp);
}


    /**
     * Display the specified resource.
     *
     * @param  \App\ContenidoProgramado  $contenidoProgramado
     * @return \Illuminate\Http\Response
     */
    public function show(ContenidoProgramado $contenidoProgramado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContenidoProgramado  $contenidoProgramado
     * @return \Illuminate\Http\Response
     */
    public function edit(ContenidoProgramado $contenidoProgramado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContenidoProgramado  $contenidoProgramado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContenidoProgramado $contenidoProgramado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContenidoProgramado  $contenidoProgramado
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContenidoProgramado $contenidoProgramado)
    {
        //
    }
}