<?php

namespace App\Http\Controllers\Registro;

use App\FileGuia;
use App\Homework;
use App\Http\Controllers\Controller;
use App\Models\Cursos\Category;
use App\Models\Registro\Inscripcion;
use App\Models\Registro\CursoProgramado;
use App\Models\Registro\ContenidoProgramado;
use App\Models\Cursos\Curso;
use App\Models\Cursos\Leccion;
use App\Models\Cursos\Prueba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;

class CursoProgramadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $curso = Curso::find($request->curso_id);
        return view('registro.index-schedule')->with('curso',$curso);
    }

    public function getAllSchedule($curso_id,$active){
        if($active == "enable")
        $cursos = CursoProgramado::with(['instructor','category'])->where('curso_id',$curso_id)->where('activo', 'si')->get();
        elseif($active == "disable")
        $cursos = CursoProgramado::with(['instructor','category'])->where('curso_id',$curso_id)->where('activo', 'no')->get();
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
        $categories = Category::all();
        $curso = Curso::find($request->curso_id);

        $instructor = User::whereHas('roles', function ($q) {
            $q->where('roles.slug', '=', 'instructor'); // or whatever constraint you need here
        })->get();

        $curso_programado = new CursoProgramado;
        $curso_programado->curso_id = $curso->id;

        return view('registro.create-schedule')
            ->with('curso',$curso)
            ->with('instructores',$instructor)
            ->with('curso_programado',$curso_programado)
            ->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* dd($request); */
        $curso = new CursoProgramado();
        $curso->identificador = $request->identificador;
        $curso->user_id = $request->instructor;
        $curso->curso_id = $request->curso_id;
        $curso->fecha_inicio = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $request->fecha_inicio))); // $request->fecha_inicio;
        $curso->fecha_fin = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $request->fecha_fin))); // $request->fecha_fin;
        $curso->fecha_inicio_venta = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $request->fecha_inicio_venta))); // $request->fecha_inicio_venta;
        $curso->fecha_fin_venta = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $request->fecha_fin_venta))); // $request->fecha_fin_venta;
        $curso->precio = $request->precio;
        $curso->category_id = $request->category_id;
        $curso->clave_descuento = $request->clave_descuento;
        //$curso->activo = "si";
        //\Log::debug(dd($curso));
        $curso->save();
        $id_curso_programado = $curso->id;
        $curso = Curso::find($curso->curso_id);

        $category_name = Category::find($request->category_id);

        if ($category_name->name == 'Guias') {
            //Obtenemos la url del documento de esta forma $imageUrl = $request->file('image')->store('simuladores', 'public');
            $fileUrl = $request->file('guia_file');
            $url = basename(Storage::put('files/medias', $fileUrl));


            FileGuia::create([
                'url' => $url,
                'curso_programado_id' => $id_curso_programado
            ]);

        }
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
        $categories = Category::all();
        $curso = Curso::find($request->curso_id);

        $curso_programado = CursoProgramado::where('id',$request->cp_id)
            ->where('curso_id',$request->curso_id)->first();

        $instructor = User::whereHas('roles', function ($q) {
            $q->where('roles.slug', '=', 'instructor'); // or whatever constraint you need here
        })->get();

        return view('registro.create-schedule')
                    ->with('curso',$curso)
                    ->with('instructores',$instructor)
                    ->with('curso_programado',$curso_programado)
                    ->with('categories',$categories);
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
        $curso->fecha_inicio_venta = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $request->fecha_inicio_venta))); // $request->fecha_inicio_venta;
        $curso->fecha_fin_venta = date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $request->fecha_fin_venta))); // $request->fecha_fin_venta;
        $curso->precio = $request->precio;
        $curso->category_id = $request->category_id;
        $curso->clave_descuento = $request->clave_descuento;
        //$curso->activo = "si";
        //\Log::debug(dd($curso));
        $curso->save();
        $curso = Curso::find($curso->curso_id);

        $id_curso_programado = $curso->id;
        $category_name = Category::find($request->category_id);
        //Valida si es guia y si $request->file('guia_file') no es vacio
        if ($category_name->name == 'Guias') {
            if ($request->file('guia_file')) {
                //Obtenemos la url del documento de esta forma $imageUrl = $request->file('image')->store('simuladores', 'public');
                $fileUrl = $request->file('guia_file');
                $url = basename(Storage::put('files/medias', $fileUrl));

                //Busca el registro actual y reemplaza la url
                $fileGuia = FileGuia::where('curso_programado_id', $request->curso_programado_id)->first();
                if ($fileGuia) {
                    $fileGuia->url = $url;
                    $fileGuia->save();
                }else{
                    FileGuia::create([
                        'url' => $fileUrl,
                        'curso_programado_id' => $request->curso_programado_id
                    ]);
                }
                /* dd($fileGuia); */
            }
        }
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

        if ($curso->category->name == "Guias") {
            /* return "Aqui la guia"; */
            return view('registro.curso')->with('curso_programado',$curso)->with('inscrito',$inscripcion)->with('contenido_programado',$contenido_programado);
        }else{
            // Calculate Progress
            $completedLessons = \DB::table('leccion_user')
                ->where('user_id', Auth::user()->id)
                ->where('curso_programado_id', $request->curso_programado_id)
                ->pluck('leccion_id')
                ->toArray();

            $totalCursoClases = 0;
            foreach ($curso->Curso->Lecciones as $modulo) {
                $totalClases = $modulo->Clases->count();
                $totalCursoClases += $totalClases;
                $completedCount = 0;
                foreach ($modulo->Clases as $clase) {
                    if (in_array($clase->id, $completedLessons)) {
                        $completedCount++;
                    }
                }
                $modulo->progress = $totalClases > 0 ? round(($completedCount / $totalClases) * 100) : 0;
                $modulo->completedCount = $completedCount;
                $modulo->totalClases = $totalClases;
            }

            $globalProgress = $totalCursoClases > 0 ? round((count($completedLessons) / $totalCursoClases) * 100) : 0;

            return view('registro.curso')
                ->with('curso_programado',$curso)
                ->with('inscrito',$inscripcion)
                ->with('contenido_programado',$contenido_programado)
                ->with('completedLessons', $completedLessons)
                ->with('globalProgress', $globalProgress);
        }

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

        $homework = Homework::where('leccion_id', $leccion->id)
                            ->where('user_id', Auth::user()->id)
                            ->first();

        // Obtener lecciones completadas por el usuario en este curso programado

        $completedLessons = \DB::table('leccion_user')
            ->where('user_id', Auth::user()->id)
            ->where('curso_programado_id', $request->curso_programado_id)
            ->pluck('leccion_id')
            ->toArray();

        // Calcular progreso por módulo
        $totalCursoClases = 0;
        foreach ($curso->Curso->Lecciones as $modulo) {
            $totalClases = $modulo->Clases->count();
            $totalCursoClases += $totalClases;
            $completedCount = 0;
            foreach ($modulo->Clases as $clase) {
                if (in_array($clase->id, $completedLessons)) {
                    $completedCount++;
                }
            }
            $modulo->progress = $totalClases > 0 ? round(($completedCount / $totalClases) * 100) : 0;
            $modulo->completedCount = $completedCount;
            $modulo->totalClases = $totalClases;
        }

        // Calcular progreso global del curso
        $globalProgress = $totalCursoClases > 0 ? round((count($completedLessons) / $totalCursoClases) * 100) : 0;

        return view('registro.leccion')->with('leccion',$leccion)
            ->with('curso_programado_id',$request->curso_programado_id)
            ->with('curso_programado',$curso)
            ->with('inscripcion_id',$request->inscripcion_id)
            ->with('contenido_programado',$contenido_programado)
            ->with('inscrito',$inscripcion)
            ->with('videoext',$videoext)
            ->with('homework',$homework)
            ->with('completedLessons', $completedLessons)
            ->with('globalProgress', $globalProgress)
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





    public function viewGuia(Request $request){

        /* dd($request); */

        if($request->file){
            $file = $request->file;
            return view('guias')->with('file',$file)->with('titulo','Contenido Protegido');
        }else{
            $file = FileGuia::where('curso_programado_id', $request->curso_programado_id)->first();
            $file = 'alumno/medias/archivo/'.$file->url;
            return view('guias')->with('file',$file)->with('titulo','Contenido Protegido');
        }
    }


    public function copyUsersForm($id_curso)
    {
        $curso_programado = CursoProgramado::find($id_curso);

        //todos los cursos programados activos menos el actual
        $otros_cursos = CursoProgramado::where('activo','si')
            ->where('id','<>',$id_curso)
            ->with('Curso')
            ->get();

        /* dd($otros_cursos); */
        return view('admin.registro.copy-users-form')->with('curso_programado',$curso_programado)->with('otros_cursos',$otros_cursos);
    }


    public function getAlumnosByCurso($id_curso)
    {
        $curso = CursoProgramado::with('Inscritos')->find($id_curso);

        if (!$curso) {
            return response()->json(['error' => 'Curso no encontrado'], 404);
        }

        return response()->json($curso->Inscritos); // aquí usamos tu relación
    }


    public function agregarAlumnos(Request $request, $id)
    {


        $cursoProgramado = CursoProgramado::findOrFail($id);


        // Agregar los alumnos seleccionados al curso programado
        foreach ($request->alumnos as $alumnoId) {
            $inscripcion = New Inscripcion();
            $inscripcion->user_id = $alumnoId;
            $inscripcion->curso_programado_id = $cursoProgramado->id;
            $inscripcion->referencia = 'Inscripción agregada por administrador';
            $inscripcion->tipo_pago = 'Administrativo';
            $inscripcion->clave = null;
            $inscripcion->aceptado = 'si';
            $inscripcion->save();
        }

        return view('admin.registro.index')->with('success', 'Alumnos inscritos correctamente')->with('curso_programado',$cursoProgramado);
    }

    public function toggleLessonCompletion(Request $request)
    {
        $user = Auth::user();
        $leccionId = $request->leccion_id;
        $cursoProgramadoId = $request->curso_programado_id;

        // Check if already completed
        $exists = \DB::table('leccion_user')
            ->where('user_id', $user->id)
            ->where('leccion_id', $leccionId)
            ->where('curso_programado_id', $cursoProgramadoId)
            ->exists();

        if ($exists) {
            // Unmark
            \DB::table('leccion_user')
                ->where('user_id', $user->id)
                ->where('leccion_id', $leccionId)
                ->where('curso_programado_id', $cursoProgramadoId)
                ->delete();
            $status = 'marked';
        }

        // Recalculate Progress
        $completedLessons = \DB::table('leccion_user')
            ->where('user_id', $user->id)
            ->where('curso_programado_id', $cursoProgramadoId)
            ->pluck('leccion_id')
            ->toArray();

        $curso = CursoProgramado::with(['Curso' => function($r){
            $r->with(['Lecciones' =>function($q){
                $q->where('leccion_id',0)->where('activo','si');
            }])->get();
        }])->find($cursoProgramadoId);

        $totalCursoClases = 0;
        $totalCursoCompletadas = count($completedLessons);
        $moduleProgress = 0;
        $moduleCompleted = 0;
        $moduleTotal = 0;

        // Find the specific module for the toggled lesson
        $currentModuleId = Leccion::find($leccionId)->leccion_id;

        foreach ($curso->Curso->Lecciones as $modulo) {
            $modTotal = $modulo->Clases->count();
            $totalCursoClases += $modTotal;
            
            if ($modulo->id == $currentModuleId) {
                $modCompleted = 0;
                foreach ($modulo->Clases as $clase) {
                    if (in_array($clase->id, $completedLessons)) {
                        $modCompleted++;
                    }
                }
                $moduleCompleted = $modCompleted;
                $moduleTotal = $modTotal;
                $moduleProgress = $modTotal > 0 ? round(($modCompleted / $modTotal) * 100) : 0;
            }
        }

        $globalProgress = $totalCursoClases > 0 ? round(($totalCursoCompletadas / $totalCursoClases) * 100) : 0;

        return response()->json([
            'status' => $status,
            'globalProgress' => $globalProgress,
            'moduleProgress' => $moduleProgress,
            'moduleCompleted' => $moduleCompleted,
            'moduleTotal' => $moduleTotal,
            'moduleId' => $currentModuleId
        ]);
    }


} 