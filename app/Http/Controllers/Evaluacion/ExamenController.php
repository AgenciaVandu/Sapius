<?php

namespace App\Http\Controllers\Evaluacion;

use App\Models\Evaluacion\Examen;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cursos\Prueba;
use App\Models\Cursos\Pregunta;
use App\Models\Cursos\Respuesta;
use App\Http\Controllers\Registro\CursoProgramadoController as Curso;
use App\Http\Controllers\Registro\CursoProgramadoController;
use App\Mail\ExamenFinalizado;
use App\Models\Cursos\Curso as CursosCurso;
use App\Models\Registro\CursoProgramado;
use App\Models\Registro\Inscripcion;
use Barryvdh\DomPDF\PDF;
use Mail;
use ZipArchive;

class ExamenController extends Controller
{
    public function previo($prueba_id, $inscripcion_id)
    {
        $examen = Prueba::withCount(['Examenes' => function ($q) use ($inscripcion_id) {
            $q->where('inscripcion_id', $inscripcion_id)->where('finalizado', 'si');
        }])->find($prueba_id);


        $desPrueba = Prueba::find($prueba_id);

        $desPrueba = $desPrueba->descripcion;



        if ($examen->oportunidades == $examen->examenes_count) {
            $examen = Prueba::with(['Examenes' => function ($q) use ($inscripcion_id) {
                $q->where('inscripcion_id', $inscripcion_id)->where('finalizado', 'si');
            }])->find($prueba_id);

            //dd($examen->Examenes);

            return view('evaluacion.resultados')->with('examen', $examen);
        }


        return view('evaluacion.previo')->with('prueba_id', $prueba_id)->with('inscripcion_id', $inscripcion_id)->with('examen', $examen)->with('desPrueba', $desPrueba);
    }

    public function presentar(Request $request)
    {
        //verificar si hay alguna prueba iniciada
        $examen = Examen::with(['Inscripcion', 'Prueba'])->where('inscripcion_id', $request->inscripcion_id)->where('prueba_id', $request->prueba_id)->first();

        if ($request->ajax() && $examen->finalizado == 'si') {
            $fin =  view('evaluacion.finalizar-imprevisto')->with('examen_id', $examen->id)
                ->with('leccion_id', $examen->Prueba->leccion_id)
                ->with('curso_programado_id', $examen->Inscripcion->curso_programado_id)
                ->with('inscripcion_id', $examen->inscripcion_id);

            return response()->json($fin->render());
        }



        $prueba = Prueba::withCount(['Preguntas' => function ($q) {
            $q->where('activo', 'si');
        }])->with('Leccion.Curso')->find($request->prueba_id);

        //dd($prueba->preguntas_count);
        // $preguntas =Pregunta::with(['Respuestas' => function($q1){
        //                 $q1->where('activo','si');
        //             }])->where('activo','si')->where('prueba_id',$request->prueba_id)->paginate(1);

        $preguntas = Pregunta::with(['GrupoPreguntas' => function ($q) use ($request) {
            $q->with(['Respuestas' => function ($q1) {
                $q1->where('activo', 'si');
            }])->where('prueba_id', $request->prueba_id);
        }])->where('activo', 'si')
            ->where('prueba_id', $request->prueba_id)
            ->select('slug')
            ->inRandomOrder(Auth::user()->id)
            ->groupBy('slug')
            ->paginate(1);

        //dd($preguntas);

        $respuestas = collect([]);

        // si apenas va empezar la prueba, damos de alta el examen
        if ($examen == null) {
            $examen = new Examen;
            $examen->inscripcion_id = $request->inscripcion_id;
            $examen->prueba_id = $request->prueba_id;
            $examen->total_preguntas = $prueba->preguntas_count;
            $examen->save();
        }

        //cargamos las respuestas previamente guaradadas en BD
        if ($examen->respuestas_json != null) {
            $respuestas = collect(json_decode($examen->respuestas_json));
        }

        //agregamos las respuestas nuevas, o editamos las ya respondidas en caso de haber tenido cambios
        if ($request->respuestas != '') {
            $r = collect(json_decode($request->respuestas));

            $r->each(function ($item1, $key) use ($respuestas) {
                $v = $respuestas->search(function ($item2, $key) use ($item1) {
                    return $item2->name == $item1->name;
                });

                if ($v !== false) {
                    $respuestas[$v]->value = $item1->value; //editamos las que ya estaban
                } else {
                    $respuestas->push($item1); //agregamos las nuevas
                }
            });

            $examen->respuestas_json = $respuestas->toJson();
            $examen->save();
        }

        //valimos si llegamos al final de la paginacion
        $final = $preguntas->currentPage() == $preguntas->lastPage();

        //solictud de nuevas respuestas para la paginacion
        $preguntasAll = Pregunta::with(['GrupoPreguntas' => function ($q) use ($request) {
            $q->with(['Respuestas' => function ($q1) {
                $q1->where('activo', 'si');
            }])->where('prueba_id', $request->prueba_id);
        }])->where('activo', 'si')
            ->where('prueba_id', $request->prueba_id)
            ->select('slug')
            ->inRandomOrder(Auth::user()->id)
            ->groupBy('slug')
            ->get();
        if ($request->ajax()) {
            $preguntas_html = view('evaluacion.preguntas', compact('preguntas', 'respuestas', 'final', 'examen'))->render();

            $respuestas_json = json_decode($examen->respuestas_json, true);
            // Asegúrate de enviar $preguntasAll también, si no lo tienes, pásalo desde el controlador
            $respuestas_status_html = view('evaluacion.respuestas_status', compact('preguntasAll', 'respuestas_json'))->render();

            return response()->json([
                'preguntas' => $preguntas_html,
                'respuestas_status' => $respuestas_status_html,
            ]);
        }

        //dd($preguntas);
        //presentacion de las primeras preguntas
        if ($examen->finalizado == "si") {
            return  redirect()->route('alumno.home');
        } else {
            return view('evaluacion.prueba')
                ->with('prueba', $prueba)
                ->with('preguntasAll', $preguntasAll)
                ->with('preguntas', $preguntas)
                ->with('examen', $examen)
                ->with('respuestas', $respuestas)
                ->with('final', $final);
        }
    }

    public function formFinalizar($examen_id)
    {
        $examen = Examen::with(['Inscripcion', 'Prueba'])->where('id', $examen_id)->first();
        return view('evaluacion.finalizar')
            ->with('examen_id', $examen_id)
            ->with('leccion_id', $examen->Prueba->leccion_id)
            ->with('curso_programado_id', $examen->Inscripcion->curso_programado_id)
            ->with('inscripcion_id', $examen->inscripcion_id);
    }

    public function formFinalizarImprevisto(Request $request)
    {
        $examen = Examen::with(['Inscripcion', 'Prueba'])->where('id', $request->examen_id)->first();
        $examen->finalizado = 'si';
        $examen->retro_visualizado = 'si';
        $examen->save();

        $fin =  view('evaluacion.finalizar-imprevisto')->with('examen_id', $examen->id)
            ->with('leccion_id', $examen->Prueba->leccion_id)
            ->with('curso_programado_id', $examen->Inscripcion->curso_programado_id)
            ->with('inscripcion_id', $examen->inscripcion_id);

        return response()->json($fin->render());
    }

    public function finalizar(Request $request)
    {
        $examen = Examen::with('Prueba')->where('id', $request->examen_id)->first();
        $examen->total_correctas = 0;

        $examen->score_total = 700; //csi es ceneval

        if ($examen->Prueba->tipo == 'ENARM') {
            $examen->score_total = 0;
        }

        $respuestas = collect(json_decode($examen->respuestas_json));

        $respuestas_db = Respuesta::with(['Pregunta' => function ($q1) use ($examen) {
            $q1->where('prueba_id', $examen->prueba_id);
        }])->where('correcto', 1)->where('activo', 'si')->get();

        $respuestas->each(function ($r, $key) use ($respuestas_db, $examen) {
            $v = $respuestas_db->search(function ($rdb, $key) use ($r) {
                return $rdb->id == $r->value && $rdb->pregunta_id == $r->name;
            });

            if ($v !== false) {
                $examen->total_correctas++;
                $examen->score_total += $respuestas_db[$v]->Pregunta->score;
            }

            //\Log::debug(print_r($v,true));
        });

        //dd($examen->total_correctas);

        //$examen->score_total = $examen->total_correctas / $examen->total_preguntas;
        $examen->finalizado = 'si';

        $examen->save();

        // $mail = Mail::to(Auth::user()->email);
        // $correo_examen_finalizado = new ExamenFinalizado($examen);
        // $mail->send($correo_examen_finalizado);

        session()->flash('examen_finalizado', true);

        $send = new Curso;
        return $send->leccionDetallada($request);
    }

    public function feedback(Request $request)
    {
        $examen = Examen::with('Prueba')->where('id', $request->examen_id)->first();

        if ($examen == null) {
            return  redirect()->route('alumno.home');
        }
        if ($examen->retro_visualizado == 'no') {
            $examen->retro_visualizado = 'si';
            $examen->save();
        }

        $respuestas = collect(json_decode($examen->respuestas_json));

        $respuestas_db = Respuesta::with(['Pregunta' => function ($q1) use ($examen) {
            $q1->with('Respuestas')
                ->where('prueba_id', $examen->prueba_id)
                ->where('activo', 'si');
        }])->where('correcto', 1)->where('activo', 'si')->get();

        $feedback = [];

        $respuestas->each(function ($r, $key) use ($respuestas_db, &$feedback) {
            $v = $respuestas_db->search(function ($rdb, $key) use ($r) {
                return $rdb->id == $r->value && $rdb->pregunta_id == $r->name;
            });

            if ($v === false) { //incorrecta
                $r_db = $respuestas_db->search(function ($rdb, $key) use ($r) {
                    return $rdb->pregunta_id == $r->name;
                });

                $feedback[] = [$r, $respuestas_db[$r_db]];
            }
        });

        $respuestas_db->each(function ($rdb, $key) use ($respuestas, &$feedback) {
            $v = $respuestas->search(function ($r, $key) use ($rdb) {
                return $rdb->pregunta_id == $r->name;
            });

            if ($v === false) { //no la encontró, lo que significa que no fue respondida
                $o = (object)['name' => 0, 'value' => 0];
                $feedback[] = [$o, $rdb];
            }
        });


        return view('evaluacion.feedback')->with('examen', $examen)->with('feedback', $feedback);
    }

    public function feedbackFinalizar(Request $request)
    {

        $fin =  view('evaluacion.feedback-finalizar');

        return response()->json($fin->render());
    }

    public function eventos(Request $request)
    {
        $examen = Examen::where('id', $request->examen_id)->first();
        $array = [];
        if (isset($examen->eventos)) {
            $array = $examen->eventos;
        }
        array_push($array, ["fecha_hora" => date('Y-m-d H:i:s'), "observacion" => $request->observacion, "tecla" => $request->tecla, "lugar" => $request->lugar]);
        $examen->eventos = $array;
        $examen->save();
    }

    public function listaResultados($inscripcion_id)
    {
        $inscripcion  =  Inscripcion::find($inscripcion_id);
        $curso = CursosCurso::find($inscripcion->CursoProgramado->curso_id);
        $lecciones = $curso->lecciones;
        $examenes = Examen::with('Prueba')->where('inscripcion_id', $inscripcion_id)->get();
        return view('admin.registro.resultados')->with('examenes', $examenes,)->with('lecciones', $lecciones)->with('inscripcion', $inscripcion);
    }



    public function cambiarEstadoFinalizado(Request $request)
    {
        $examen = Examen::findOrFail($request->id);
        if ($examen->finalizado == 'si') {
            $examen->finalizado = 'no';
        } else {
            // Si el examen no está finalizado, lo marcamos como finalizado
            $examen->finalizado = 'si';
        }
        $examen->save();

        return response()->json([
            'message' => 'Estado de finalizado actualizado correctamente.',
            'nuevo_estado' => $examen->finalizado
        ]);
    }

    public function cambiarEstadoRetro(Request $request)
    {
        $examen = Examen::findOrFail($request->id);
        // Cambiamos el estado de retroalimentación
        if ($examen->retro_visualizado == 'si') {
            $examen->retro_visualizado = 'no';
        } else {
            $examen->retro_visualizado = 'si';
        }

        $examen->save();

        return response()->json([
            'message' => 'Estado de retroalimentación actualizado correctamente.',
            'nuevo_estado' => $examen->retro_visualizado
        ]);
    }



    public function listaResultadosAlumno($inscripcion_id)
    {
        $inscripcion  =  Inscripcion::find($inscripcion_id);
        $curso = CursosCurso::find($inscripcion->CursoProgramado->curso_id);
        $lecciones = $curso->lecciones;

        $conPrueba = Examen::with('Prueba')
            ->where('inscripcion_id', $inscripcion_id)
            ->has('Prueba')
            ->get();

        $sinPrueba = Examen::with('Prueba')
            ->where('inscripcion_id', $inscripcion_id)
            ->doesntHave('Prueba')
            ->get();

        $examenes = $conPrueba->merge($sinPrueba);

        return view('alumno.resultados')->with('examenes', $examenes)->with('lecciones', $lecciones)->with('inscripcion', $inscripcion);
    }

    public function exportReport($inscripcion_id)
    {
        $inscripcion = Inscripcion::find($inscripcion_id);

        // Eager load lecciones and pruebas to reduce queries
        $curso = CursosCurso::with('lecciones')->find($inscripcion->CursoProgramado->curso_id);

        // Eager load Prueba for all examenes in a single query
        $examenes = Examen::with('Prueba')
            ->where('inscripcion_id', $inscripcion_id)
            ->get();

        // If you need to separate conPrueba/sinPrueba, you can filter in-memory
        // $conPrueba = $examenes->filter(fn($e) => $e->Prueba !== null);
        // $sinPrueba = $examenes->filter(fn($e) => $e->Prueba === null);

        // Render PDF view with eager loaded data
        /* return view('alumno.exportresultados')->with('examenes', $examenes)->with('lecciones', $curso->lecciones)->with('inscripcion', $inscripcion); */
        $pdf = \PDF::loadView('alumno.exportresultados', [
            'examenes' => $examenes,
            'lecciones' => $curso->lecciones,
            'inscripcion' => $inscripcion
        ]);

        return $pdf->download($inscripcion->User->getNombreCompletoAttribute() . ' - ' . date('Y-m-d H:i:s') . '.pdf');
    }

    public function getInscritos($curso_id, $active = 'si')
    {
        //$curso = Inscripcion::with('Inscritos')->where('curso_programado_id',$curso_id)->first();
        $curso = CursoProgramado::with(['Inscritos' => function ($query) use ($active) {
            $query->where('inscripciones.aceptado', $active);
        }])->find($curso_id);
        //$curso = CursoProgramado::with('Inscritos')->find($curso_id);
        //dd($curso);
        return $curso->Inscritos->toJson();
    }

    public function exportAllStudentResults($curso_id)
    {
        $inscritos = $this->getInscritos($curso_id, 'si');
        $inscritos = json_decode($inscritos);
        $array_inscritos_id = [];

        foreach ($inscritos as $inscrito) {
            $inscripcion = Inscripcion::where('user_id', $inscrito->id)
                ->where('curso_programado_id', $curso_id)
                ->first();

            if ($inscripcion) {
                $array_inscritos_id[] = $inscripcion->id;
            }
        }

        // Carpeta temporal para los PDFs
        $tempPath = storage_path('app/temp_reports');
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0777, true);
        }

        // Generar PDFs individuales
        $pdfFiles = [];
        foreach ($array_inscritos_id as $inscripcion_id) {
            $inscripcion = Inscripcion::find($inscripcion_id);
            $curso = CursosCurso::with('lecciones')->find($inscripcion->CursoProgramado->curso_id);
            $examenes = Examen::with('Prueba')->where('inscripcion_id', $inscripcion_id)->get();

            $pdf = \PDF::loadView('alumno.exportresultados', [
                'examenes' => $examenes,
                'lecciones' => $curso->lecciones,
                'inscripcion' => $inscripcion
            ]);

            $fileName = $inscripcion->User->getNombreCompletoAttribute() . ' - ' . date('Y-m-d') . '.pdf';
            $filePath = $tempPath . '/' . $fileName;

            $pdf->save($filePath); // Guardamos en carpeta temporal
            $pdfFiles[] = $filePath;
        }

        // Crear el ZIP
        $zipFileName = 'ResultadosCurso-' . $curso_id . '-' . date('Y-m-d') . '.zip';
        $zipPath = storage_path('app/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($pdfFiles as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        }

        // Eliminar PDFs temporales
        foreach ($pdfFiles as $file) {
            unlink($file);
        }

        // Retornar descarga del ZIP
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
