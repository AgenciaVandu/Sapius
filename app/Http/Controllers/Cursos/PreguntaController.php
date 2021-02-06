<?php

namespace App\Http\Controllers\Cursos;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cursos\Respuesta;
use App\Models\Cursos\Pregunta;
use App\Models\Cursos\Prueba;
use App\Models\Cursos\Leccion;
use App\Models\Cursos\Curso;
use Illuminate\Support\Facades\Storage;
use App\Utilerias\Importador;

class PreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prueba = Prueba::find($request->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('preguntas.index')->with('prueba',$prueba)
                                    ->with('leccion',$leccion)
                                    ->with('curso',$curso)
                                    ->with('modulo',$modulo)
                                    ->with('clase',$leccion);
    }

    public function getAll($prueba_id,$active)
    {
        if($active == "enable")
        $preguntas = Pregunta::where('prueba_id',$prueba_id)->where('activo', 'si')->get();
        elseif($active == "disable")
        $preguntas = Pregunta::where('prueba_id',$prueba_id)->where('activo', 'no')->get();
        return $preguntas->toJson();
    }

    public function showimportar($prueba_id)
    {
        $prueba = Prueba::find($prueba_id);
        //\Log::debug(dd($prueba));
        return view('preguntas.importar')->with('prueba',$prueba);
    }

    public function importar(Request $request)
    {
        //dd( $_FILES);
        $tmpfname = $_FILES['file']['tmp_name'];
        \Log::info("*********************************************");
        \Log::info("Iniciar proceso importación nómina :: ".date("Y-m-d H:i:s"));
        //$tmpfname = $_FILES['excel']['tmp_name'];

        $cabecera = $this->cabecera();
        $estructura = $this->estructura();
        //\Log::debug(dd($estructura));
        $importador = new Importador($tmpfname,$cabecera,$estructura);
        \Log::info("Obtener datos del archivo :: ".date("Y-m-d H:i:s"));
        $preguntas = $importador->make();
        \Log::info("Iniciar Insersión a base de datos :: ".date("Y-m-d H:i:s"));
        //\Log::debug(dd($preguntas));
        foreach ($preguntas as $pregunta) {
            //eliminar pregunta vacia
            if($pregunta['pregunta'] == ""){
                //\Log::debug(dd($preguntas));
                continue;
            }
            $respuestasArr = Arr::pull($pregunta,'respuestas');
            //remover las propiedades no necesarias
            //Arr::pull($pregunta,'agrupador');
            $correcto = Arr::pull($pregunta,'correcto');
            $correcto = $correcto - 1;
            //agregar el identificador de a prueba
            $pregunta['prueba_id'] = $request->prueba_id;

            $pregunta['imagen'] = null;
            //$pregunta['score'] = 1;

            //dd($pregunta);
            $pregunta = Pregunta::create($pregunta);

            $respuestas = [];
            foreach ($respuestasArr as $key=>$respuesta) {
                //establece la respuesta correcta
                if($key == $correcto){
                    $respuesta['correcto'] = 1;
                }else{
                    $respuesta['correcto'] = 0;
                }

                $respuesta['pregunta_id'] = $pregunta->id;
                array_push($respuestas,$respuesta);
                //dd($respuesta);
            }
            //dd($respuestas);
            $respuestas = Respuesta::insert($respuestas);
        }
        dd('Ok...');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $prueba = Prueba::find($request->prueba_id);
        //\Log::debug(dd($prueba));
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('preguntas.create')->with('prueba',$prueba)
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
        $pregunta = new Pregunta();

        $pregunta->prueba_id = $request->prueba_id;
        $pregunta->pregunta = $request->pregunta;
        $pregunta->slug = $request->slug;
        $pregunta->opciones = $request->opciones;
        $pregunta->imagen = $this->imageUploadPost($request);
        $pregunta->score = $request->score;
        $pregunta->save();
        $prueba = Prueba::find($pregunta->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('preguntas.index')->with('success', 'La pregunta ha sido agregada correctamente')
                                                    ->with('prueba',$prueba)
                                                    ->with('leccion',$leccion)
                                                    ->with('curso',$curso)
                                                    ->with('modulo',$modulo)
                                                    ->with('clase',$leccion);


    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Pregunta  $pregunta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pregunta = Pregunta::find($id);
        return view('preguntas.show',compact('pregunta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pregunta  $pregunta
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $pregunta = Pregunta::find($request->id);
        $prueba = Prueba::find($pregunta->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('preguntas.edit')->with('pregunta',$pregunta)
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
     * @param  \App\Pregunta  $pregunta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pregunta = Pregunta::find($request->id);
        $pregunta->pregunta = $request->pregunta;
        $pregunta->slug = $request->slug;
        $pregunta->opciones = $request->opciones;
        $pregunta->imagen = $this->imageUploadPost($request);
        $pregunta->score = $request->score;
        $pregunta->save();
        $prueba = Prueba::find($pregunta->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('preguntas.index')->with('success', 'La pregunta ha sido actualizado correctamente')
                                                    ->with('prueba',$prueba)
                                                    ->with('leccion',$leccion)
                                                    ->with('curso',$curso)
                                                    ->with('modulo',$modulo)
                                                    ->with('clase',$leccion);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pregunta  $pregunta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pregunta = Pregunta::find($request->id);
        $pregunta->activo = "no";
        $pregunta->save();
        $prueba = Prueba::find($pregunta->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('preguntas.index')->with('prueba',$prueba)
                                    ->with('leccion',$leccion)
                                    ->with('curso',$curso)
                                    ->with('modulo',$modulo)
                                    ->with('clase',$leccion);
    }

    public function activate(Request $request)
    {
        $pregunta = Pregunta::find($request->id);
        $pregunta->activo = "si";
        $pregunta->save();
        $prueba = Prueba::find($pregunta->prueba_id);
        $leccion = Leccion::find($prueba->leccion_id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('preguntas.index')->with('prueba',$prueba)
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
        $name = basename(Storage::put('images/preguntas', $file));
        return $name;
    }

    public function cursoPicture($file)
    {
        $storagePath = storage_path('app/images/preguntas/' . $file);
        return response()->file($storagePath);
    }

    public function cabecera(){
        $cabecera = [
            ['nombre' => 'slug','tipo' => 'string','columna' => ''],//0
            ['nombre' => 'pregunta','tipo' => 'string','columna' => ''],//1
            ['nombre' => 'retro','tipo' => 'string','columna' => ''],//2
            ['nombre' => 'correcta','tipo' => 'string','columna' => ''],//3
            ['nombre' => 'score','tipo' => 'string','columna' => ''],//4
        ];
        return collect($cabecera);
    }

    public function estructura(){
        $preguntas = [
            'prueba_id'=> -1,
            'slug' => 0,
            'pregunta'=> 1,
            'opciones' => 2,
            'imagen' => -1,
            'score' => 4,
            'correcto' => 3,
            "respuestas" =>[
                "secuencia_despues" =>2,
                "secuencia_antes" =>3,
                "rango" =>1,
                "elementos"=> [
                    //"pregunta_id" => -1,
                    "respuesta" => 1
                    // "imagen" => -1,
                    // "correcto" => -1,
                    // "posicion" => -1
                ]
            ]
        ];

        return $preguntas;
    }
}
