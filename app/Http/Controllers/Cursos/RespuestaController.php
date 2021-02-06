<?php

namespace App\Http\Controllers\Cursos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cursos\Respuesta;
use App\Models\Cursos\Pregunta;
use App\Models\Cursos\Prueba;
use App\Models\Cursos\Leccion;
use App\Models\Cursos\Curso;
use Illuminate\Support\Facades\Storage;

class RespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pregunta = Pregunta::find($request->pregunta_id);
        $prueba = Prueba::find($pregunta->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('respuestas.index')->with('pregunta',$pregunta)
                                       ->with('prueba',$prueba)
                                       ->with('leccion',$leccion)
                                       ->with('curso',$curso)
                                       ->with('modulo',$modulo)
                                       ->with('clase',$leccion);
    }

    public function getAll($pregunta_id,$active)
    {
        if($active == "enable")
        $respuestas = Respuesta::where('pregunta_id',$pregunta_id)->where('activo', 'si')->get();
        elseif($active == "disable")
        $respuestas = Respuesta::where('pregunta_id',$pregunta_id)->where('activo', 'no')->get();
        return $respuestas->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pregunta = Pregunta::find($request->pregunta_id);
        $prueba = Prueba::find($pregunta->prueba_id);
        //\Log::debug(dd($prueba));
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('respuestas.create')->with('pregunta',$pregunta)
                                       ->with('prueba',$prueba)
                                       ->with('leccion',$leccion)
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
        $respuesta = new Respuesta();

        $respuesta->pregunta_id = $request->pregunta_id;
        $respuesta->respuesta = $request->respuesta;
        $respuesta->imagen = $this->imageUploadPost($request);
        $respuesta->correcto = $request->correcto;
        $respuesta->posicion = $request->posicion;
        $respuesta->activo = "si";
        $respuesta->save();
        $pregunta = Pregunta::find($respuesta->pregunta_id);
        $prueba = Prueba::find($pregunta->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('respuestas.index')->with('success', 'La respuesta ha sido agregada correctamente')
                                                    ->with('pregunta',$pregunta)
                                                    ->with('prueba',$prueba)
                                                    ->with('leccion',$leccion)
                                                    ->with('curso',$curso)
                                                    ->with('modulo',$modulo)
                                                    ->with('clase',$leccion);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Respuesta  $Respuesta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $respuesta = Respuesta::find($id);
        return view('respuestas.show',compact('respuesta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Respuesta  $Respuesta
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //dd($request);
        $respuesta = Respuesta::find($request->id);
        $pregunta = Pregunta::find($respuesta->pregunta_id);
        $prueba = Prueba::find($pregunta->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        //\Log::debug(dd($respuesta));
        return view('respuestas.edit')->with('respuesta',$respuesta)
                                     ->with('pregunta',$pregunta)
                                     ->with('prueba',$prueba)
                                     ->with('leccion',$leccion)
                                     ->with('curso',$curso)
                                     ->with('modulo',$modulo)
                                     ->with('clase',$leccion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Respuesta  $Respuesta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $respuesta = Respuesta::find($request->id);

        $respuesta->respuesta = $request->respuesta;
        $respuesta->imagen = $this->imageUploadPost($request);
        $respuesta->correcto = $request->correcto;
        $respuesta->posicion = $request->posicion;
        $respuesta->save();
        $pregunta = Pregunta::find($respuesta->pregunta_id);
        $prueba = Prueba::find($pregunta->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('respuestas.index')->with('success', 'La respuesta ha sido actualizada correctamente')
                                                    ->with('pregunta',$pregunta)
                                                    ->with('prueba',$prueba)
                                                    ->with('leccion',$leccion)
                                                    ->with('curso',$curso)
                                                    ->with('modulo',$modulo)
                                                    ->with('clase',$leccion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Respuesta  $Respuesta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $respuesta = Respuesta::find($request->id);
        $respuesta->activo = "no";
        $respuesta->save();
        $pregunta = Pregunta::find($respuesta->pregunta_id);
        $prueba = Prueba::find($pregunta->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('respuestas.index')->with('pregunta',$pregunta)
                                       ->with('prueba',$prueba)
                                       ->with('leccion',$leccion)
                                       ->with('curso',$curso)
                                       ->with('modulo',$modulo)
                                       ->with('clase',$leccion);
    }

    public function activate(Request $request)
    {
        $respuesta = Respuesta::find($request->id);
        $respuesta->activo = "si";
        $respuesta->save();
        $pregunta = Pregunta::find($respuesta->pregunta_id);
        $prueba = Prueba::find($pregunta->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('respuestas.index')->with('pregunta',$pregunta)
                                       ->with('prueba',$prueba)
                                       ->with('leccion',$leccion)
                                       ->with('curso',$curso)
                                       ->with('modulo',$modulo)
                                       ->with('clase',$leccion);
    }

    public function imageUploadPost(Request $request)
    {
        $file = $request->file('image');
        //\Log::debug(dd($file));
        if(is_null($file) || $request->imgEliminar == "si"){
            //\Log::debug(dd("file null"));
            return null;
        }
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        // ]);
        $name = basename(Storage::put('images/respuestas', $file));
        return $name;
    }

    public function cursoPicture($file)
    {
        $storagePath = storage_path('app/images/respuestas/' . $file);
        return response()->file($storagePath);
    }
}
