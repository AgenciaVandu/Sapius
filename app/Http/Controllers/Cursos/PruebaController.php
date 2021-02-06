<?php

namespace App\Http\Controllers\Cursos;

use App\Models\Cursos\Respuesta;
use App\Models\Cursos\Pregunta;
use App\Models\Cursos\Prueba;
use App\Models\Cursos\Leccion;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PruebaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $leccion = Leccion::find($request->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        //\Log::debug(dd($leccion));
        return view('pruebas.index')->with('leccion',$leccion)
                                    ->with('curso',$curso)
                                    ->with('modulo',$modulo)
                                    ->with('clase',$leccion);
    }

    public function getAll($leccion_id,$active)
    {
        if($active == "enable")
        $pruebas = Prueba::where('leccion_id',$leccion_id)->where('activo', 'si')->get();
        elseif($active == "disable")
        $pruebas = Prueba::where('leccion_id',$leccion_id)->where('activo', 'no')->get();
        return $pruebas->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $leccion = Leccion::find($request->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('pruebas.create')->with('leccion',$leccion)
                                     ->with('curso',$curso)
                                     ->with('modulo',$modulo)
                                     ->with('clase',$leccion);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prueba = new Prueba();

        $prueba->curso_id = $request->curso_id;
        $prueba->leccion_id = $request->leccion_id;
        $prueba->titulo = $request->titulo;
        $prueba->descripcion = $request->descripcion;
        $prueba->tiempo = $request->tiempo;
        $prueba->tiempo_caducidad = $request->tiempo_caducidad;
        $prueba->tiempo_vigencia = $request->tiempo_vigencia;
        $prueba->tipo = $request->tipo;
        $prueba->activo = "si";
        $prueba->save();
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('pruebas.index')->with('success', 'La prueba ha sido agregada correctamente')
                                                    ->with('leccion',$leccion)
                                                    ->with('curso',$curso)
                                                    ->with('modulo',$modulo)
                                                    ->with('clase',$leccion);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prueba  $prueba
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prueba = Prueba::find($id);
        return view('pruebas.show',compact('prueba'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prueba  $prueba
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $prueba = Prueba::find($request->id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('pruebas.edit')->with('prueba',$prueba)
                                     ->with('leccion',$leccion)
                                     ->with('curso',$curso)
                                     ->with('modulo',$modulo)
                                     ->with('clase',$leccion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prueba  $prueba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $prueba = Prueba::find($request->id);
        $prueba->titulo = $request->titulo;
        $prueba->descripcion = $request->descripcion;
        $prueba->tiempo = $request->tiempo;
        $prueba->tiempo_caducidad = $request->tiempo_caducidad;
        $prueba->tiempo_vigencia = $request->tiempo_vigencia;
        $prueba->tipo = $request->tipo;
        $prueba->save();
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);

        return view('pruebas.index')->with('success', 'La prueba ha sido actualizada correctamente')
                                                    ->with('leccion',$leccion)
                                                    ->with('curso',$curso)
                                                    ->with('modulo',$modulo)
                                                    ->with('clase',$leccion);
    }

    public function duplicate(Request $request)
    {
        $prueba = Prueba::find($request->id);
        $preguntas = Pregunta::where('prueba_id', '=', $prueba->id)->get();
        //verifica el las pruebas con el mismo nombre
        $pruebas = Prueba::where('id', '=', $prueba->id)->get();
        $count = count($pruebas) + 1;
        $prueba = $prueba->replicate();
        $prueba->titulo = $prueba->titulo.$count;
        $prueba->save();

        //\Log::debug(dd($preguntas));
        foreach ($preguntas as $pregunta){
            $respuestas = Respuesta::where('pregunta_id', '=', $pregunta->id)->get();
            $pregunta = $pregunta->replicate();
            $pregunta->prueba_id = $prueba->id;
            $pregunta->save();
            foreach ($respuestas as $respuesta){
                $respuesta = $respuesta->replicate();
                $respuesta->pregunta_id = $pregunta->id;
                $respuesta->save();
            }
        }
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('pruebas.index')->with('success', 'La prueba se duplico correctamente')
                                                    ->with('leccion',$leccion)
                                                    ->with('curso',$curso)
                                                    ->with('modulo',$modulo)
                                                    ->with('clase',$leccion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prueba  $prueba
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $prueba = Prueba::find($request->id);
        $prueba->activo = "no";
        $prueba->save();
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('pruebas.index')->with('leccion',$leccion)
                                    ->with('curso',$curso)
                                    ->with('modulo',$modulo)
                                    ->with('clase',$leccion);
    }

    public function activate(Request $request)
    {
        $prueba = Prueba::find($request->id);
        $prueba->activo = "si";
        $prueba->save();
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('pruebas.index')->with('leccion',$leccion)
                                    ->with('curso',$curso)
                                    ->with('modulo',$modulo)
                                    ->with('clase',$leccion);
    }
}
