<?php

namespace App\Http\Controllers\Cursos;

use App\Models\Cursos\Curso;
use App\Models\Registro\ContenidoProgramado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cursos\Category;
use App\Models\Registro\CursoProgramado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Conekta\Conekta;
use Conekta\Model\Customer;
use Conekta\Order;
use DateTime;
use DateInterval;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Curso::where('activo', 'si')->get();
        return (Auth::user()->rol[0]->slug =='admin') ? view('cursos.index',compact('cursos')) : view('instructor.cursos-index');
    }

    public function getAll($active)
    {
        if($active == "enable")
            $cursos = Curso::where('activo', 'si')->get();
        elseif($active == "disable")
            $cursos = Curso::where('activo', 'no')->get();
        return $cursos->toJson();
    }

    public function getAllForInstructor($active)
    {
        $cursos = Curso::withCount(['CursoProgramado' => function($q){
            $q->where('user_id',Auth::user()->id);
        }])->where('activo', 'si')->get();

        return $cursos->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //vista
        $categories = Category::all();
        return view('cursos.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $curso = new Curso;

        $curso->user_id = auth()->user()->id;
        $curso->titulo = $request->titulo;
        $curso->slug = $request->slug;
        $curso->descripcion = $request->descripcion;
        $curso->imagen = $this->imageUploadPost($request);
        $curso->activo = "si";
        $curso->save();
        return redirect()->route(Auth::user()->rol[0]->slug.'.cursos.index')->with('success', 'El curso ha sido agregado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $curso = Curso::find($id);
        return view('cursos.show',compact('curso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $curso = Curso::find($request->id);
        //\Log::debug(dd($curso));
        $edit = true;
        return view('cursos.edit')->with('curso',$curso)->with('edit',$edit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $curso = Curso::find($request->id);
        $curso->titulo = $request->titulo;
        $curso->slug = $request->slug;
        $curso->descripcion = $request->descripcion;
        if ($this->imageUploadPost($request) != null) {
            $curso->imagen = $this->imageUploadPost($request);
        }
        $curso->save();
        return redirect()->route(Auth::user()->rol[0]->slug.'.cursos.index')->with('success', 'El curso ha sido actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $curso = Curso::find($request->id);
        $curso->activo = "no";
        //\Log::debug(dd($curso));
        $curso->save();
        return redirect()->route(Auth::user()->rol[0]->slug.'.cursos.index');
    }

    public function activate(Request $request)
    {
        $curso = Curso::find($request->id);
        $curso->activo = "si";
        //\Log::debug(dd($curso));
        $curso->save();
        return redirect()->route(Auth::user()->rol[0]->slug.'.cursos.index');
    }

    public function delete(Request $request)
    {
        $curso = Curso::find($request->id);
        $curso->delete();
        return redirect()->route(Auth::user()->rol[0]->slug.'.cursos.index');
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
        $name = basename(Storage::put('images/cursos', $file));
        return $name;
    }

    public function cursoPicture($file)
    {
        $storagePath = storage_path('app/images/cursos/' . $file);
        return response()->file($storagePath);
    }

    public function video()
    {
        //vista
        return view('cursos.video');
    }

    public function token()
    {
        //vista
        return view('cursos.token');
    }

    public function payment2()
    {
        //vista
        return view('cursos.payment2');
    }

    public function checkout($curso_id){
        $curso = CursoProgramado::with('Curso')->where('id',$curso_id)->first();
        dd($curso->id);
        return view('checkout', compact('curso'));
    }


    public function copyIndex()
    {
        $cursos = Curso::all();
        return view('cursos.copy-index',compact('cursos'));
    }

    public function copyCreate(Request $request)
    {

        if ($request->copyAll) {

        $cursoOriginal = Curso::find($request->curso_id);

        $curso = new Curso;

        $curso->user_id = auth()->user()->id;
        $curso->titulo = $cursoOriginal->titulo . ' (Copia)';
        $curso->slug = $cursoOriginal->slug . '-copia-' . time();
        $curso->descripcion = $cursoOriginal->descripcion;
        $curso->imagen = $cursoOriginal->imagen;
        $curso->activo = "si";
        $curso->save();

        /* dd($cursoOriginal->Lecciones); */
        // Copiar las lecciones
        if (!empty($cursoOriginal->Lecciones) && is_iterable($cursoOriginal->Lecciones)) {

            // Closure para copiar pruebas -> preguntas -> respuestas de una lección origen a una lección destino
            $copyPruebas = function ($leccionOrigen, $leccionDestino) use ($curso) {
            if (!empty($leccionOrigen->Pruebas) && is_iterable($leccionOrigen->Pruebas)) {
                foreach ($leccionOrigen->Pruebas as $pruebaOriginal) {
                $prueba = $pruebaOriginal->replicate();
                $prueba->curso_id = $curso->id;
                $prueba->leccion_id = $leccionDestino->id;
                $prueba->save();

                // Copiar preguntas de la prueba
                if (!empty($pruebaOriginal->Preguntas) && is_iterable($pruebaOriginal->Preguntas)) {
                    foreach ($pruebaOriginal->Preguntas as $preguntaOriginal) {
                    $pregunta = $preguntaOriginal->replicate();
                    $pregunta->prueba_id = $prueba->id;
                    $pregunta->save();

                    // Copiar respuestas de la pregunta
                    if (!empty($preguntaOriginal->Respuestas) && is_iterable($preguntaOriginal->Respuestas)) {
                        foreach ($preguntaOriginal->Respuestas as $respuestaOriginal) {
                        $respuesta = $respuestaOriginal->replicate();
                        $respuesta->pregunta_id = $pregunta->id;
                        $respuesta->save();
                        }
                    }
                    }
                }
                }
            }
            };

            // Closure para copiar media
            $copyMedia = function ($leccionOrigen, $leccionDestino) use ($curso) {
                if (!empty($leccionOrigen->Medias) && is_iterable($leccionOrigen->Medias)) {
                    foreach ($leccionOrigen->Medias as $mediaOriginal) {
                        $media = $mediaOriginal->replicate();
                        // $media->curso_id = $curso->id; // Removed as column doesn't exist
                        $media->leccion_id = $leccionDestino->id;
                        $media->save();
                    }
                }
            };

            foreach ($cursoOriginal->Lecciones->where('leccion_id', 0) as $leccionOriginal) {
            $leccion = $leccionOriginal->replicate();
            $leccion->curso_id = $curso->id;
            $leccion->save();

            // Copiar pruebas/preguntas/respuestas de la lección padre
            $copyPruebas($leccionOriginal, $leccion);
            // Copiar media de la lección padre
            $copyMedia($leccionOriginal, $leccion);

            // Validar y copiar lecciones hijas
            $leccionesHijas = $cursoOriginal->Lecciones->where('leccion_id', $leccionOriginal->id);
            foreach ($leccionesHijas as $leccionHijaOriginal) {
                $leccionHija = $leccionHijaOriginal->replicate();
                $leccionHija->curso_id = $curso->id;
                $leccionHija->leccion_id = $leccion->id; // Asignar el nuevo id de la lección padre
                $leccionHija->save();

                // Copiar pruebas/preguntas/respuestas de la lección hija
                $copyPruebas($leccionHijaOriginal, $leccionHija);
                // Copiar media de la lección hija
                $copyMedia($leccionHijaOriginal, $leccionHija);
            }
            }
        }

        return redirect()->route(Auth::user()->rol[0]->slug.'.cursos.index')->with('success', 'El curso ha sido copiado correctamente');
        } else {
            $cursoOriginal = Curso::find($request->curso_id);
            return redirect()->route('admin.cursos.details.copy',$cursoOriginal);
        }
    }

    //Funcion para poder obtener todos los contenidos de un curso y listarlos en una vista la cual dara paso a que se copie toda la informacion seleccionada
    public function getAllContentOfCurso(Curso $curso){
        /* dd($curso); */
        return view('cursos.copy-details',compact('curso'));
    }


    public function copySelectContentOfCourse(Request $request){
        $itemsSeleccionados = $request->items; // IDs de módulos y clases que seleccionó el usuario

        $cursoOriginal = Curso::find($request->curso_id);

        $curso = new Curso;
        $curso->user_id = auth()->user()->id;
        $curso->titulo = $cursoOriginal->titulo . ' (Copia)';
        $curso->slug = $cursoOriginal->slug . '-copia-' . time();
        $curso->descripcion = $cursoOriginal->descripcion;
        $curso->imagen = $cursoOriginal->imagen;
        $curso->activo = "si";
        $curso->save();

        // --------------------------------------------------
        // CARGAR SOLO LAS LECCIONES SELECCIONADAS
        // --------------------------------------------------
        $leccionesSeleccionadas = $cursoOriginal->Lecciones->whereIn('id', $itemsSeleccionados);

        // Módulos = leccion_id = 0
        $modulos = $leccionesSeleccionadas->where('leccion_id', 0);

        // Clases = leccion_id != 0
        $clases = $leccionesSeleccionadas->where('leccion_id', '!=', 0);

        // Aquí guardaremos el id nuevo de cada módulo copiado
        $nuevosModulos = [];

        // --------------------------------------------------
        // FUNCIÓN PARA COPIAR PRUEBAS, PREGUNTAS, RESPUESTAS
        // --------------------------------------------------
        $copyPruebas = function ($leccionOrigen, $leccionDestino) use ($curso) {
            if (!empty($leccionOrigen->Pruebas) && is_iterable($leccionOrigen->Pruebas)) {
                foreach ($leccionOrigen->Pruebas as $pruebaOriginal) {

                    $prueba = $pruebaOriginal->replicate();
                    $prueba->curso_id = $curso->id;
                    $prueba->leccion_id = $leccionDestino->id;
                    $prueba->save();

                    // Copiar preguntas
                    if (!empty($pruebaOriginal->Preguntas)) {
                        foreach ($pruebaOriginal->Preguntas as $preguntaOriginal) {

                            $pregunta = $preguntaOriginal->replicate();
                            $pregunta->prueba_id = $prueba->id;
                            $pregunta->save();

                            // Copiar respuestas
                            if (!empty($preguntaOriginal->Respuestas)) {
                                foreach ($preguntaOriginal->Respuestas as $respuestaOriginal) {

                                    $respuesta = $respuestaOriginal->replicate();
                                    $respuesta->pregunta_id = $pregunta->id;
                                    $respuesta->save();
                                }
                            }
                        }
                    }
                }
            }
        };

        // Closure para copiar media
        $copyMedia = function ($leccionOrigen, $leccionDestino) use ($curso) {
            if (!empty($leccionOrigen->Medias) && is_iterable($leccionOrigen->Medias)) {
                foreach ($leccionOrigen->Medias as $mediaOriginal) {
                    $media = $mediaOriginal->replicate();
                    // $media->curso_id = $curso->id; // Removed as column doesn't exist
                    $media->leccion_id = $leccionDestino->id;
                    $media->save();
                }
            }
        };

        // --------------------------------------------------
        // 1) COPIAR SOLO LOS MÓDULOS QUE EL USUARIO SELECCIONÓ
        // --------------------------------------------------
        foreach ($modulos as $moduloOriginal) {

            $nuevoModulo = $moduloOriginal->replicate();
            $nuevoModulo->curso_id = $curso->id;
            $nuevoModulo->leccion_id = 0; // sigue siendo módulo
            $nuevoModulo->save();

            // Guardamos relación viejo_id → nuevo_id
            $nuevosModulos[$moduloOriginal->id] = $nuevoModulo->id;

            // Copiar pruebas del módulo
            $copyPruebas($moduloOriginal, $nuevoModulo);
            // Copiar media del módulo
            $copyMedia($moduloOriginal, $nuevoModulo);
        }

        // --------------------------------------------------
        // 2) COPIAR SOLO LAS CLASES QUE FUERON SELECCIONADAS
        // --------------------------------------------------
        foreach ($clases as $claseOriginal) {

            // Importante: si el módulo de esta clase NO fue seleccionado → no se copia
            if (!isset($nuevosModulos[$claseOriginal->leccion_id])) {
                continue;
            }

            $nuevaClase = $claseOriginal->replicate();
            $nuevaClase->curso_id = $curso->id;
            $nuevaClase->leccion_id = $nuevosModulos[$claseOriginal->leccion_id]; // asignar el módulo nuevo
            $nuevaClase->save();

            // Copiar pruebas de la clase
            $copyPruebas($claseOriginal, $nuevaClase);
            // Copiar media de la clase
            $copyMedia($claseOriginal, $nuevaClase);
        }

        return redirect()
            ->route(Auth::user()->rol[0]->slug . '.cursos.index')
            ->with('success', 'El curso ha sido copiado correctamente con la selección indicada.');

    }


}
