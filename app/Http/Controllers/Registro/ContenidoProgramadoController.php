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
        $curso = CursoProgramado::with(['Curso.Lecciones' => function($q){
            $q->with('Clases')->where('leccion_id',0);
        }])->find($request->cp_id);

        //dd($curso);
        $contenido_programado = ContenidoProgramado::where('curso_programado_id',$request->cp_id)->first();
        $curso_original = Curso::find($curso->curso_id);
        return view('registro.index-contenido')
                ->with('cp',$curso)
                ->with('contenido_programado',$contenido_programado)
                ->with('curso_original',$curso_original)
                ->with('curso',$curso)
                ->with('curso_programado',$curso);
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
        $curso = Curso::with('Lecciones')->find($request->curso_id);
        $contenido_programado = ContenidoProgramado::where('curso_programado_id',$request->curso_programado_id)->first();
        $contenido_programado = ($contenido_programado)? $contenido_programado : new ContenidoProgramado();
        $contenido_programado->curso_programado_id = $request->curso_programado_id;
        $arr = [];
        foreach($curso->lecciones  as $leccion){
            $arr[] = [
                'id' => $request->{'leccion_id_'.$leccion->id},
                'fecha_inicial' => $request->{'fecha_inicial_'.$leccion->id},
                'fecha_final' => $request->{'fecha_final_'.$leccion->id},
            ];
        }
        $contenido_programado->contenido = $arr;
        $contenido_programado->save();

        $curso = CursoProgramado::with(['Curso.Lecciones' => function($q){
            $q->with('Clases')->where('leccion_id',0);
        }])->find($request->curso_programado_id);
        
        $curso_original = Curso::find($curso->curso_id);
        //dd($curso);
        return view('registro.index-contenido')->with('cp',$curso)
                                               ->with('contenido_programado',$contenido_programado)
                                               ->with('curso_original',$curso_original)
                                               ->with('curso',$curso)
                                               ->with('curso_programado',$curso);
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
