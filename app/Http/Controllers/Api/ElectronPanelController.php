<?php

namespace App\Http\Controllers\Api;

use App\Homework;
use App\FileGuia;
use App\Models\Cursos\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro\CursoProgramado;
use App\Models\Registro\Inscripcion;
use App\Models\Registro\ContenidoProgramado;
use App\Models\Cursos\Curso;
use App\Models\Cursos\Leccion;
use App\Models\Cursos\Prueba;
use App\Models\Cursos\Pregunta;
use App\Models\Cursos\Respuesta;
use App\Models\Evaluacion\Examen;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TareaEmail;

class ElectronPanelController extends Controller
{
    private function validateMacAddress(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return 'user_null';
        }
        if ($user->hasRole('alumno')) {
            $mac = $request->header('X-Sapius-MAC');
            if (!$mac) {
                return 'mac_header_missing';
            }
            if ($mac !== $user->mac_address) {
                return 'mac_mismatch:received_' . var_export($mac, true) . '_vs_db_' . var_export($user->mac_address, true);
            }
        }
        return 'valid';
    }

    public function dashboard(Request $request)
    {
        $val = $this->validateMacAddress($request);
        if ($val !== 'valid') {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado: ' . $val], 403);
        }

        $user = $request->user();

        $mis_cursos = Inscripcion::whereHas('CursoProgramado', function ($query) {
            $query->with('Curso')->where('fecha_inicio_venta', '<=', date('Y-m-d H:i:s'))
                ->where('fecha_fin', '>=', date('Y-m-d H:i:s'));
        })->with(['CursoProgramado.Curso', 'CursoProgramado.category'])->where('user_id', $user->id)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'nombre_completo' => $user->nombre_completo,
                    'username' => $user->username,
                    'email' => $user->email,
                    'is_blocked' => $user->is_blocked,
                    'mac_address' => $user->mac_address
                ],
                'mis_cursos' => $mis_cursos
            ]
        ]);
    }

    public function courseDetails(Request $request, $curso_programado_id)
    {
        if (!$this->validateMacAddress($request)) {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado.'], 403);
        }

        $user = $request->user();
        
        $inscripcion = Inscripcion::where('curso_programado_id', $curso_programado_id)
            ->where('user_id', $user->id)->first();
            
        if (!$inscripcion) {
            return response()->json(['success' => false, 'message' => 'No estás inscrito en este curso.'], 403);
        }

        $curso = CursoProgramado::with(['Curso' => function($r){
            $r->with(['Lecciones' => function($q){
                $q->where('leccion_id', 0)->where('activo', 'si')->with(['Clases' => function($c){
                    $c->where('activo', 'si');
                }]);
            }])->get();
        }])->find($curso_programado_id);

        $contenido_programado = ContenidoProgramado::where('curso_programado_id', $curso_programado_id)->first();

        if ($curso->category->name == "Guias") {
            $fileGuia = FileGuia::where('curso_programado_id', $curso_programado_id)->first();
            return response()->json([
                'success' => true,
                'data' => [
                    'curso_programado' => $curso,
                    'inscrito' => $inscripcion,
                    'contenido_programado' => $contenido_programado,
                    'guia' => $fileGuia ? 'alumno/medias/archivo/'.$fileGuia->url : null
                ]
            ]);
        }

        $completedLessons = DB::table('leccion_user')
            ->where('user_id', $user->id)
            ->where('curso_programado_id', $curso_programado_id)
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

        $unlockedLessonsData = \App\Models\Registro\LessonUnlock::where('user_id', $user->id)
            ->where('curso_programado_id', $curso_programado_id)
            ->get()
            ->keyBy('leccion_id');

        return response()->json([
            'success' => true,
            'data' => [
                'curso_programado' => $curso,
                'inscrito' => $inscripcion,
                'contenido_programado' => $contenido_programado,
                'completedLessons' => $completedLessons,
                'globalProgress' => $globalProgress,
                'unlockedLessonsData' => $unlockedLessonsData
            ]
        ]);
    }

    public function lessonDetails(Request $request, $leccion_id, $curso_programado_id)
    {
        if (!$this->validateMacAddress($request)) {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado.'], 403);
        }

        $user = $request->user();

        $inscripcion = Inscripcion::where('curso_programado_id', $curso_programado_id)
            ->where('user_id', $user->id)->first();
            
        if (!$inscripcion) {
            return response()->json(['success' => false, 'message' => 'No estás inscrito en este curso.'], 403);
        }

        $leccion = Leccion::with(['Pruebas' => function($q){
            $q->where('activo', 'si');
            $q->with('Preguntas');
        }, 'Medias' => function($q){
            $q->where('activo', 'si');
        }, 'Curso' => function($q1) use ($leccion_id){
            $q1->with(['Lecciones' => function($q2) use ($leccion_id){
                $q2->with('Clases')->where('activo', 'si')->where("id", "<>", $leccion_id);
            }])->get();
        }])->find($leccion_id);

        if (!$leccion) {
            return response()->json(['success' => false, 'message' => 'Lección no encontrada.'], 404);
        }

        $video = null;
        $videoext = null;
        $video = $leccion->Medias->filter(function($m) {
            return $m->tipo == "video";
        })->first();
        
        $videoext = $leccion->Medias->filter(function($m) {
            return $m->tipo == "videoext";
        })->first();

        // Eliminar los videos de la lista de medias para mostrarlos por separado
        $leccion->Medias = $leccion->Medias->filter(function($m) {
            return $m->tipo <> "video";
        });

        $homework = Homework::where('leccion_id', $leccion->id)
            ->where('user_id', $user->id)
            ->first();

        $completedLessons = DB::table('leccion_user')
            ->where('user_id', $user->id)
            ->where('curso_programado_id', $curso_programado_id)
            ->pluck('leccion_id')
            ->toArray();

        $unlockedLessonsData = \App\Models\Registro\LessonUnlock::where('user_id', $user->id)
            ->where('curso_programado_id', $curso_programado_id)
            ->get()
            ->keyBy('leccion_id');

        return response()->json([
            'success' => true,
            'data' => [
                'leccion' => $leccion,
                'video' => $video,
                'videoext' => $videoext,
                'homework' => $homework,
                'completedLessons' => $completedLessons,
                'unlockedLessonsData' => $unlockedLessonsData,
                'inscripcion_id' => $inscripcion->id
            ]
        ]);
    }

    public function toggleLessonCompletion(Request $request)
    {
        if (!$this->validateMacAddress($request)) {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado.'], 403);
        }

        $user = $request->user();
        $leccionId = $request->leccion_id;
        $cursoProgramadoId = $request->curso_programado_id;

        $exists = DB::table('leccion_user')
            ->where('user_id', $user->id)
            ->where('leccion_id', $leccionId)
            ->where('curso_programado_id', $cursoProgramadoId)
            ->exists();

        if ($exists) {
            DB::table('leccion_user')
                ->where('user_id', $user->id)
                ->where('leccion_id', $leccionId)
                ->where('curso_programado_id', $cursoProgramadoId)
                ->delete();
            $status = 'unmarked';
        } else {
            DB::table('leccion_user')->insert([
                'user_id' => $user->id,
                'leccion_id' => $leccionId,
                'curso_programado_id' => $cursoProgramadoId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $status = 'marked';
        }

        // Recalcular Progreso
        $completedLessons = DB::table('leccion_user')
            ->where('user_id', $user->id)
            ->where('curso_programado_id', $cursoProgramadoId)
            ->pluck('leccion_id')
            ->toArray();

        $curso = CursoProgramado::with(['Curso' => function($r){
            $r->with(['Lecciones' => function($q){
                $q->where('leccion_id', 0)->where('activo', 'si');
            }])->get();
        }])->find($cursoProgramadoId);

        $totalCursoClases = 0;
        $totalCursoCompletadas = count($completedLessons);
        $moduleProgress = 0;
        $moduleCompleted = 0;
        $moduleTotal = 0;

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
            'success' => true,
            'data' => [
                'status' => $status,
                'globalProgress' => $globalProgress,
                'moduleProgress' => $moduleProgress,
                'moduleCompleted' => $moduleCompleted,
                'moduleTotal' => $moduleTotal,
                'moduleId' => $currentModuleId
            ]
        ]);
    }

    public function homeworkTracking(Request $request, $curso_programado_id)
    {
        if (!$this->validateMacAddress($request)) {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado.'], 403);
        }

        $user = $request->user();

        $curso = CursoProgramado::with(['Curso' => function($r){
            $r->with(['Lecciones' => function($q){
                $q->with(['Clases' => function($c) {
                    $c->where('activo', 'si');
                }]);
                $q->where('leccion_id', 0)->where('activo', 'si'); // Módulos
            }])->get();
        }])->find($curso_programado_id);

        $leccionIds = [];
        foreach ($curso->Curso->Lecciones as $modulo) {
            foreach ($modulo->Clases as $clase) {
                $leccionIds[] = $clase->id;
            }
        }

        $homeworks = Homework::where('user_id', $user->id)
            ->whereIn('leccion_id', $leccionIds)
            ->get()
            ->keyBy('leccion_id');

        $contenidoProgramado = ContenidoProgramado::where('curso_programado_id', $curso_programado_id)->first();
        $schedule = $contenidoProgramado && $contenidoProgramado->contenido ? $contenidoProgramado->contenido : [];

        $unlockedLessonsData = \App\Models\Registro\LessonUnlock::where('user_id', $user->id)
            ->where('curso_programado_id', $curso_programado_id)
            ->get()
            ->keyBy('leccion_id');

        return response()->json([
            'success' => true,
            'data' => [
                'curso_programado' => $curso,
                'modulos' => $curso->Curso->Lecciones,
                'homeworks' => $homeworks,
                'schedule' => $schedule,
                'unlockedLessonsData' => $unlockedLessonsData
            ]
        ]);
    }

    public function sendHomework(Request $request)
    {
        if (!$this->validateMacAddress($request)) {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado.'], 403);
        }

        $user = $request->user();
        $leccion_id = $request->leccion_id;
        $curso_programado_id = $request->curso_programado_id;

        $leccion = Leccion::find($leccion_id);
        $curso_programado = CursoProgramado::find($curso_programado_id);
        $instructor = \App\User::find($curso_programado->user_id);

        if (!$request->hasFile('documento')) {
            return response()->json(['success' => false, 'message' => 'El archivo de la tarea es requerido.'], 400);
        }

        $file = $request->file('documento');
        $ruta = Storage::put('tareas', $file);

        $datos = [
            'nombre' => $user->nombre_completo,
            'leccion' => $leccion->titulo,
            'tarea' => $request->tarea ?? 'Entregado vía Electron'
        ];

        try {
            $copia = $user->email;
            Mail::to($instructor->email)->cc([$copia, 'tareas@sapius.com.mx'])->send(new TareaEmail($datos));
        } catch (\Exception $e) {
            // Log warning but continue process as mail service might fail
        }

        $isLate = false;
        $contenidoProgramado = ContenidoProgramado::where('curso_programado_id', $curso_programado_id)->first();
        if ($contenidoProgramado && $contenidoProgramado->contenido) {
            $schedule = collect($contenidoProgramado->contenido);
            $scheduleItem = $schedule->firstWhere('id', $leccion->id);
            if (!$scheduleItem) {
                $scheduleItem = $schedule->firstWhere('id', $leccion->leccion_id);
            }
            if ($scheduleItem && isset($scheduleItem['fecha_final'])) {
                try {
                    $endFormat = 'd/m/Y';
                    $endStr = $scheduleItem['fecha_final'];
                    if (isset($scheduleItem['hora_final'])) {
                        $endFormat .= ' H:i';
                        $endStr .= ' ' . $scheduleItem['hora_final'];
                    }
                    $fechaFinal = \Carbon\Carbon::createFromFormat($endFormat, $endStr);
                    if (!isset($scheduleItem['hora_final'])) {
                        $fechaFinal->setTime(23, 59, 59);
                    }
                    if (\Carbon\Carbon::now()->gt($fechaFinal)) {
                        $isLate = true;
                    }
                } catch (\Exception $e) {}
            }
        }

        $homework = new Homework();
        $homework->leccion_id = $leccion->id;
        $homework->user_id = $user->id;
        $homework->is_late = $isLate;
        $homework->save();

        return response()->json([
            'success' => true,
            'message' => 'Tarea enviada con éxito.',
            'data' => $homework
        ]);
    }

    public function examPrevio(Request $request, $prueba_id, $inscripcion_id)
    {
        if (!$this->validateMacAddress($request)) {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado.'], 403);
        }

        $examen = Prueba::withCount(['Examenes' => function ($q) use ($inscripcion_id) {
            $q->where('inscripcion_id', $inscripcion_id)->where('finalizado', 'si');
        }])->find($prueba_id);

        if (!$examen) {
            return response()->json(['success' => false, 'message' => 'Prueba no encontrada.'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'prueba' => $examen,
                'oportunidades_restantes' => $examen->oportunidades - $examen->examenes_count
            ]
        ]);
    }

    public function examPresentar(Request $request)
    {
        if (!$this->validateMacAddress($request)) {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado.'], 403);
        }

        $user = $request->user();
        $inscripcion_id = $request->inscripcion_id;
        $prueba_id = $request->prueba_id;

        $examen = Examen::with(['Inscripcion', 'Prueba'])
            ->where('inscripcion_id', $inscripcion_id)
            ->where('prueba_id', $prueba_id)
            ->first();

        if ($examen && $examen->finalizado == 'si') {
            return response()->json(['success' => false, 'message' => 'Este examen ya ha sido finalizado.'], 400);
        }

        $prueba = Prueba::withCount(['Preguntas' => function ($q) {
            $q->where('activo', 'si');
        }])->with('Leccion.Curso')->find($prueba_id);

        $preguntas = Pregunta::with(['GrupoPreguntas' => function ($q) use ($prueba_id) {
            $q->with(['Respuestas' => function ($q1) {
                $q1->where('activo', 'si');
            }])->where('prueba_id', $prueba_id);
        }])->where('activo', 'si')
            ->where('prueba_id', $prueba_id)
            ->select('slug')
            ->inRandomOrder($user->id)
            ->groupBy('slug')
            ->paginate(1);

        $respuestas = collect([]);

        if ($examen == null) {
            $examen = new Examen;
            $examen->inscripcion_id = $inscripcion_id;
            $examen->prueba_id = $prueba_id;
            $examen->total_preguntas = $prueba->preguntas_count;
            $examen->save();
        }

        if ($examen->respuestas_json != null) {
            $respuestas = collect(json_decode($examen->respuestas_json));
        }

        if ($request->respuestas != '') {
            $r = collect(json_decode($request->respuestas));
            $r->each(function ($item1, $key) use ($respuestas) {
                $v = $respuestas->search(function ($item2, $key) use ($item1) {
                    return $item2->name == $item1->name;
                });
                if ($v !== false) {
                    $respuestas[$v]->value = $item1->value;
                } else {
                    $respuestas->push($item1);
                }
            });

            $examen->respuestas_json = $respuestas->toJson();
            $examen->save();
        }

        $final = $preguntas->currentPage() == $preguntas->lastPage();

        $preguntasAll = Pregunta::with(['GrupoPreguntas' => function ($q) use ($prueba_id) {
            $q->where('prueba_id', $prueba_id);
        }])->where('activo', 'si')
            ->where('prueba_id', $prueba_id)
            ->select('slug')
            ->inRandomOrder($user->id)
            ->groupBy('slug')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'examen' => $examen,
                'preguntas' => $preguntas,
                'respuestas_guardadas' => $respuestas,
                'preguntasAll' => $preguntasAll,
                'final' => $final
            ]
        ]);
    }

    public function examFinalizar(Request $request)
    {
        if (!$this->validateMacAddress($request)) {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado.'], 403);
        }

        $examen_id = $request->examen_id;
        $examen = Examen::with('Prueba')->find($examen_id);

        if (!$examen) {
            return response()->json(['success' => false, 'message' => 'Examen no encontrado.'], 404);
        }

        $examen->total_correctas = 0;
        $examen->score_total = 700; // Ceneval base

        if ($examen->Prueba->tipo == 'ENARM') {
            $examen->score_total = 0;
        }

        $respuestas = collect(json_decode($examen->respuestas_json));

        $respuestas_db = Respuesta::with(['Pregunta' => function ($q1) use ($examen) {
            $q1->where('prueba_id', $examen->prueba_id);
        }])
        ->where('correcto', 1)
        ->where('activo', 'si')
        ->get()
        ->keyBy(function ($item) {
            return $item->pregunta_id . '-' . $item->id;
        });

        $respuestas->each(function ($r, $key) use ($respuestas_db, $examen) {
            $busqueda = $r->name . '-' . $r->value;
            if ($respuestas_db->has($busqueda)) {
                $r_db = $respuestas_db->get($busqueda);
                $examen->total_correctas++;
                if (isset($r_db->Pregunta->score)) {
                    $examen->score_total += $r_db->Pregunta->score;
                }
            }
        });

        $isLate = false;
        $inscripcion = Inscripcion::find($examen->inscripcion_id);
        if ($inscripcion) {
            $contenidoProgramado = ContenidoProgramado::where('curso_programado_id', $inscripcion->curso_programado_id)->first();
            if ($contenidoProgramado && $contenidoProgramado->contenido) {
                $schedule = collect($contenidoProgramado->contenido);
                $leccionId = $examen->Prueba->leccion_id;
                $scheduleItem = $schedule->firstWhere('id', $leccionId);
                if (!$scheduleItem) {
                    $leccion = Leccion::find($leccionId);
                    if ($leccion) {
                        $scheduleItem = $schedule->firstWhere('id', $leccion->leccion_id);
                    }
                }

                if ($scheduleItem && isset($scheduleItem['fecha_final'])) {
                    try {
                        $endFormat = 'd/m/Y';
                        $endStr = $scheduleItem['fecha_final'];
                        if (isset($scheduleItem['hora_final'])) {
                            $endFormat .= ' H:i';
                            $endStr .= ' ' . $scheduleItem['hora_final'];
                        }
                        $fechaFinal = \Carbon\Carbon::createFromFormat($endFormat, $endStr);
                        if (!isset($scheduleItem['hora_final'])) {
                            $fechaFinal->setTime(23, 59, 59);
                        }
                        if ($examen->created_at->gt($fechaFinal)) {
                            $isLate = true;
                        }
                    } catch (\Exception $e) {}
                }
            }
        }

        $examen->finalizado = 'si';
        $examen->is_late = $isLate;
        $examen->save();

        return response()->json([
            'success' => true,
            'message' => 'Examen finalizado correctamente.',
            'data' => $examen
        ]);
    }

    public function examFeedback(Request $request, $examen_id)
    {
        if (!$this->validateMacAddress($request)) {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado.'], 403);
        }

        $examen = Examen::with('Prueba')->find($examen_id);

        if ($examen == null) {
            return response()->json(['success' => false, 'message' => 'Examen no encontrado.'], 404);
        }

        if ($examen->retro_visualizado == 'no') {
            $examen->retro_visualizado = 'si';
            $examen->save();
        }

        $respuestas = collect(json_decode($examen->respuestas_json));

        $respuestas_db = Respuesta::with(['Pregunta' => function ($q1) use ($examen) {
            $q1->with(['Respuestas' => function ($q2) {
                $q2->where('activo', 'si');
            }])
            ->where('prueba_id', $examen->prueba_id)
            ->where('activo', 'si');
        }])->where('correcto', 1)->where('activo', 'si')->get();

        $correctasPorId = $respuestas_db->keyBy(function($r) { return $r->pregunta_id . '-' . $r->id; });
        $correctasPorPregunta = $respuestas_db->keyBy('pregunta_id');
        $usuarioPorPregunta = $respuestas->keyBy('name');

        $feedback = [];

        $respuestas->each(function ($r, $key) use ($correctasPorId, $correctasPorPregunta, &$feedback) {
            $llave = $r->name . '-' . $r->value;
            if (!$correctasPorId->has($llave)) {
                if ($correctasPorPregunta->has($r->name)) {
                    $feedback[] = [
                        'user_answer' => $r,
                        'correct_answer' => $correctasPorPregunta->get($r->name)
                    ];
                }
            }
        });

        $respuestas_db->each(function ($rdb, $key) use ($usuarioPorPregunta, &$feedback) {
            if (!$usuarioPorPregunta->has($rdb->pregunta_id)) {
                $o = (object)['name' => 0, 'value' => 0];
                $feedback[] = [
                    'user_answer' => $o,
                    'correct_answer' => $rdb
                ];
            }
        });

        return response()->json([
            'success' => true,
            'data' => [
                'examen' => $examen,
                'feedback' => $feedback
            ]
        ]);
    }

    public function examEventos(Request $request)
    {
        if (!$this->validateMacAddress($request)) {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado.'], 403);
        }

        $examen = Examen::find($request->examen_id);
        if (!$examen) {
            return response()->json(['success' => false, 'message' => 'Examen no encontrado.'], 404);
        }

        $array = $examen->eventos ?? [];
        array_push($array, [
            "fecha_hora" => date('Y-m-d H:i:s'),
            "observacion" => $request->observacion,
            "tecla" => $request->tecla,
            "lugar" => $request->lugar
        ]);
        
        $examen->eventos = $array;
        $examen->save();

        return response()->json(['success' => true, 'message' => 'Evento registrado.']);
    }

    public function securePdf(Request $request, $leccion_id)
    {
        if (!$this->validateMacAddress($request)) {
            return response()->json(['success' => false, 'message' => 'Dispositivo no autorizado.'], 403);
        }

        $leccion = Leccion::find($leccion_id);
        if (!$leccion || !$leccion->archivo_pdf) {
            return response()->json(['success' => false, 'message' => 'PDF no encontrado.'], 404);
        }

        $path = storage_path('app/public/' . $leccion->archivo_pdf);
        if (!file_exists($path)) {
            return response()->json(['success' => false, 'message' => 'Archivo no encontrado en el servidor.'], 404);
        }

        return Response::file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="sapius_secure.pdf"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }
}
