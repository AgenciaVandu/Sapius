<?php

namespace App\Http\Controllers\Cursos;

use App\Models\Cursos\Leccion;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\TareaEmail;
use App\Models\Registro\CursoProgramado;
use App\User;

class LeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $curso = Curso::find($request->curso_id);
        $modulo = Leccion::find($request->leccion_id);

        return view('lecciones.index')->with('curso',$curso)
                                        ->with('leccion_id',$request->leccion_id)
                                        ->with('modulo',$modulo);
    }

    public function getAll($curso_id,$leccion_id,$active)
    {
        if($active == "enable")
        $lecciones = Leccion::where('curso_id',$curso_id)->where('leccion_id',$leccion_id)->where('activo', 'si')->get();
        elseif($active == "disable")
        $lecciones = Leccion::where('curso_id',$curso_id)->where('leccion_id',$leccion_id)->where('activo', 'no')->get();
        return $lecciones->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $curso = Curso::find($request->curso_id);
        $leccion = Leccion::find($request->leccion_id);
        return view('lecciones.create')->with('curso',$curso)
                                        ->with('leccion_id',$request->leccion_id)
                                        ->with('leccion',$leccion)
                                        ->with('modulo',$leccion);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $leccion = new Leccion;

        $leccion->curso_id = $request->curso_id;
        $leccion->leccion_id = $request->leccion_id;
        $leccion->titulo = $request->titulo;
        $leccion->slug = $request->slug;
        $leccion->imagen = $this->imageUploadPost($request);
        $leccion->contenido = $request->contenido;
        $leccion->activo = "si";
        $leccion->save();
        $curso = Curso::find($leccion->curso_id);
        return view('lecciones.index')->with('success', 'El curso ha sido actualizado')
                                        ->with('curso',$curso)
                                        ->with('leccion_id',$request->leccion_id)
                                        ->with('modulo',$leccion);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leccion  $leccion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leccion = Leccion::find($id);
        return view('lecciones.show',compact('leccion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leccion  $leccion
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $leccion = Leccion::find($request->id);
        $curso = Curso::find($leccion->curso_id);
        $modulo = Leccion::find($leccion->leccion_id);
        return view('lecciones.edit')->with('leccion',$leccion)
                                       ->with('curso',$curso)
                                       ->with('modulo',$modulo)
                                       ->with('clase',$leccion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leccion  $leccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $leccion = Leccion::find($request->id);

        $leccion->titulo = $request->titulo;
        $leccion->slug = $request->slug;
        $leccion->imagen = $this->imageUploadPost($request);
        $leccion->contenido = $request->contenido;
        $leccion->save();
        $curso = Curso::find($leccion->curso_id);
        return view('lecciones.index')->with('success', 'El curso ha sido actualizado')
                                        ->with('curso',$curso)
                                        ->with('leccion_id',$leccion->leccion_id)
                                        ->with('modulo',$leccion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leccion  $leccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $leccion = Leccion::find($request->id);
        $leccion->activo = "no";
        //\Log::debug(dd($leccion));
        $leccion->save();
        $curso = Curso::find($leccion->curso_id);
        return view('lecciones.index')->with('curso',$curso)
                                        ->with('leccion_id',$leccion->leccion_id)
                                        ->with('modulo',$leccion);
    }

    public function activate(Request $request)
    {
        $leccion = Leccion::find($request->id);
        $leccion->activo = "si";
        //\Log::debug(dd($leccion));
        $leccion->save();
        $curso = Curso::find($leccion->curso_id);
        return view('lecciones.index')->with('curso',$curso)
                                        ->with('leccion_id',$leccion->leccion_id)
                                        ->with('modulo',$leccion);
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
        $name = basename(Storage::put('images/lecciones', $file));
        return $name;
    }

    public function cursoPicture($file)
    {
        $storagePath = storage_path('app/images/lecciones/' . $file);
        return response()->file($storagePath);
    }

    public function tarea(Request $request)
    {
        $leccion = Leccion::find($request->leccion_id);
        $curso_programado = CursoProgramado::find($request->curso_programado_id);
        return view('lecciones.tarea')->with('leccion',$leccion)
                                      ->with('curso_programado',$curso_programado);
    }

    public function sendTarea(Request $request)
    {
        $leccion = Leccion::find($request->leccion_id);
        $curso_programado = CursoProgramado::find($request->curso_programado_id);
        $instructor = User::find($curso_programado->user_id);
        //Subir el documento al servidor
        $file = $request->file('documento');
        $ruta = Storage::put('tareas', $file);
        //enviar el correo
        $datos = [
            'nombre' => $request->nombre,
            'leccion' => $request->leccion,
            'tarea' => $request->tarea
        ];
        $copia = Auth::user()->email;
        $mail = Mail::to($instructor->email)->cc([$copia,'tareas@sapius.com.mx']);
        //$mail = Mail::to('eduardoica_@hotmail.com');
        $m = new TareaEmail($datos);
        $m->attachFromStorage($ruta);
        $mail->send($m);

        return view('lecciones.tarea')->with('success', 'Tarea enviada')
                                      ->with('leccion',$leccion)
                                      ->with('curso_programado',$curso_programado);
    }
}
