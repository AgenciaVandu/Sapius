<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use App\Models\Registro\Inscripcion;
use App\Models\Registro\CursoProgramado;
use App\Models\Registro\ContenidoProgramado;
use App\Models\Cursos\Curso;
use App\Models\Cursos\Leccion;
use App\Models\Cursos\Prueba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class CursoProgramadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $curso = Curso::find($request->curso_id);
        return view('registro.index-schedule')->with('curso',$curso);
    }

    public function getAllSchedule($curso_id,$active){
        if($active == "enable")
        $cursos = CursoProgramado::with('instructor')->where('curso_id',$curso_id)->where('activo', 'si')->get();
        elseif($active == "disable")
        $cursos = CursoProgramado::with('instructor')->where('curso_id',$curso_id)->where('activo', 'no')->get();
        //dd($cursos);
        return $cursos->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $curso = Curso::find($request->curso_id);

        $instructor = User::whereHas('roles', function ($q) {
            $q->where('roles.slug', '=', 'instructor'); // or whatever constraint you need here
          })->get();

        $curso_programado = new CursoProgramado;
        $curso_programado->curso_id = $curso->id;

        return view('registro.create-schedule')
            ->with('curso',$curso)
            ->with('instructores',$instructor)
            ->with('curso_programado',$curso_programado);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $curso = new CursoProgramado();
        $curso->identificador = $request->identificador;
        $curso->user_id = $request->instructor;
        $curso->curso_id = $request->curso_id;
        $curso->fecha_inicio = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $request->fecha_inicio))); // $request->fecha_inicio;
        $curso->fecha_fin = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $request->fecha_fin))); // $request->fecha_fin;
        $curso->precio = $request->precio;
        $curso->clave_descuento = $request->clave_descuento;
        //$curso->activo = "si";
        //\Log::debug(dd($curso));
        $curso->save();
        $curso = Curso::find($curso->curso_id);
        return view('registro.index-schedule')->with('curso',$curso);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CursoProgramado  $cursoProgramado
     * @return \Illuminate\Http\Response
     */
    public function show(CursoProgramado $cursoProgramado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CursoProgramado  $cursoProgramado
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $curso = Curso::find($request->curso_id);

        $curso_programado = CursoProgramado::where('id',$request->cp_id)
            ->where('curso_id',$request->curso_id)->first();

        $instructor = User::whereHas('roles', function ($q) {
            $q->where('roles.slug', '=', 'instructor'); // or whatever constraint you need here
          })->get();

        return view('registro.create-schedule')
                    ->with('curso',$curso)
                    ->with('instructores',$instructor)
                    ->with('curso_programado',$curso_programado);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CursoProgramado  $cursoProgramado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $curso =  CursoProgramado::where('id',$request->curso_programado_id)->first();
        //dd($curso);
        $curso->identificador = $request->identificador;
        $curso->user_id = $request->instructor;
        $curso->curso_id = $request->curso_id;
        $curso->fecha_inicio = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $request->fecha_inicio))); // $request->fecha_inicio;
        $curso->fecha_fin = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $request->fecha_fin))); // $request->fecha_fin;
        $curso->precio = $request->precio;
        $curso->clave_descuento = $request->clave_descuento;
        //$curso->activo = "si";
        //\Log::debug(dd($curso));
        $curso->save();
        $curso = Curso::find($curso->curso_id);
        return view('registro.index-schedule')->with('curso',$curso);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CursoProgramado  $cursoProgramado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $curso = CursoProgramado::find($request->cp_id);
        $curso->activo = "no";
        //\Log::debug(dd($curso));
        $curso->save();
        $curso = Curso::find($request->curso_id);
        return view('registro.index-schedule')->with('curso',$curso);
    }

    public function cursoDetallado(Request $request){

        $inscripcion = Inscripcion::where('curso_programado_id',$request->curso_programado_id)->where('user_id',Auth::user()->id)->first();

        $curso = CursoProgramado::with(['Curso' => function($r){
                        $r->with(['Lecciones' =>function($q){
                            $q->where('leccion_id',0)->where('activo','si');
                    }])->get();
                }])->find($request->curso_programado_id);

        $contenido_programado = ContenidoProgramado::where('curso_programado_id',$request->curso_programado_id)->first();

        return view('registro.curso')->with('curso_programado',$curso)->with('inscrito',$inscripcion)->with('contenido_programado',$contenido_programado);
    }

    public function leccionDetallada(Request $request){
        $leccion = Leccion::with(['Pruebas' =>function($q){
                        $q->where('activo','si');
                        $q->with('Preguntas');
                    },'Medias' =>function($q){
                        $q->where('activo','si');
                    },'Curso'=>function($q1) use ($request){
                        $q1->with(['Lecciones' =>function($q2) use($request){
                            $q2->with('Clases')->where('activo','si')->where("id","<>",$request->leccion_id);
                        }])->get();
                    }])
                    ->find($request->leccion_id);

        $inscripcion = Inscripcion::where('curso_programado_id',$request->curso_programado_id)->where('user_id',Auth::user()->id)->first();
        $curso = CursoProgramado::with(['Curso' => function($r){
                        $r->with(['Lecciones' =>function($q){
                            $q->where('leccion_id',0)->where('activo','si');
                    }])->get();
                }])->find($request->curso_programado_id);

        $contenido_programado = ContenidoProgramado::where('curso_programado_id',$request->curso_programado_id)->first();

        //Verificar si se muestra:
        // 2.- Video de la clase en medias
        // 1.- Imagen de la clase
        $video = null;
        if($leccion->leccion_id > 0){
            $video = $leccion->Medias->filter(function($m) {
                return $m->tipo == "video";
            })->first();
        }
        $videoext = null;
        if($leccion->leccion_id > 0){
            $videoext = $leccion->Medias->filter(function($m) {
                return $m->tipo == "videoext";
            })->first();
        }
        //elimnar los videos de la lista de medias
        $leccion->Medias = $leccion->Medias->filter(function($m) {
            return $m->tipo <> "video";
        });

        return view('registro.leccion')->with('leccion',$leccion)
            ->with('curso_programado_id',$request->curso_programado_id)
            ->with('curso_programado',$curso)
            ->with('inscripcion_id',$request->inscripcion_id)
            ->with('contenido_programado',$contenido_programado)
            ->with('inscrito',$inscripcion)
            ->with('videoext',$videoext)
            ->with('video',$video);
    }

    public function listaInscritos(Request $request)
    {
        $curso = CursoProgramado::with('Curso')->find($request->curso_programado_id);
        return view('admin.registro.index')->with('curso_programado',$curso);
    }

    public function getInscritos($curso_id,$active='si')
    {
        //$curso = Inscripcion::with('Inscritos')->where('curso_programado_id',$curso_id)->first();
        $curso = CursoProgramado::with(['Inscritos' => function($query)use($active){ $query->where('inscripciones.aceptado',$active); } ])->find($curso_id);
        //$curso = CursoProgramado::with('Inscritos')->find($curso_id);
        //dd($curso);
        return $curso->Inscritos->toJson();
    }

    public function destroyInscritos(Request $request)
    {
        $inscripcion = Inscripcion::find($request->id);
        $inscripcion->aceptado = "no";
        //\Log::debug(dd($leccion));
        $inscripcion->save();

        $curso = CursoProgramado::with('Curso')->find($inscripcion->curso_programado_id);
        return view('admin.registro.index')->with('curso_programado',$curso);
    }

    public function activateInscritos(Request $request)
    {
        //\Log::debug(dd($request->id));
        $inscripcion = Inscripcion::find($request->id);
        $inscripcion->aceptado = "si";
        //\Log::debug(dd($leccion));
        $inscripcion->save();

        $curso = CursoProgramado::with('Curso')->find($inscripcion->curso_programado_id);
        return view('admin.registro.index')->with('curso_programado',$curso);
    }

}
