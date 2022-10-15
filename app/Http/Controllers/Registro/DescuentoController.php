<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registro\CursoProgramado;
use App\Models\Cursos\Curso;
use App\Models\Registro\Descuento;

class DescuentoController extends Controller
{
    public function index(Request $request)
    {
        $curso = CursoProgramado::find($request->cp_id);
        $curso_original = Curso::find($curso->curso_id);
        return view('registro.index-descuento')
                ->with('curso',$curso)
                ->with('curso_programado',$curso)
                ->with('curso_original',$curso_original);
    }

    public function getAllDescuentos($curso_programado_id)
    {
        $cursos = Descuento::where('curso_programado_id',$curso_programado_id)->get();
        //dd($cursos);
        return $cursos->toJson();
    }

    public function create(Request $request)
    {
        $descuento = new Descuento();
        $curso_programado = CursoProgramado::find($request->curso_programado_id);
        $curso = Curso::find($curso_programado->curso_id);
        return view('registro.create-descuento')
            ->with('curso_programado_id',$request->curso_programado_id)
            ->with('descuento',$descuento)
            ->with('curso_programado',$curso_programado)
            ->with('curso',$curso);
    }

    public function store(Request $request)
    {
        //dd($request);
        $descuento = new Descuento();
        $descuento->clave = $request->clave;
        $descuento->descuento = $request->descuento;
        $descuento->limite = $request->limite;
        $descuento->curso_programado_id = $request->curso_programado_id;

        $descuento->save();
        $curso = CursoProgramado::find($request->curso_programado_id);
        $curso_original = Curso::find($curso->curso_id);
        return view('registro.index-descuento')
                ->with('curso',$curso)
                ->with('curso_programado',$curso)
                ->with('curso_original',$curso_original);
    }

    public function edit(Request $request)
    {
        $descuento = Descuento::find($request->descuento_id);
        $curso_programado = CursoProgramado::find($descuento->curso_programado_id);
        $curso = Curso::find($curso_programado->curso_id);

        return view('registro.create-descuento')
            ->with('curso_programado_id',$request->curso_programado_id)
            ->with('descuento',$descuento)
            ->with('curso_programado',$curso_programado)
            ->with('curso',$curso);
    }

    public function update(Request $request)
    {
        $descuento =  Descuento::where('id',$request->descuento_id)->first();
        $descuento->clave = $request->clave;
        $descuento->descuento = $request->descuento;
        $descuento->limite = $request->limite;
        $descuento->curso_programado_id = $request->curso_programado_id;

        $descuento->save();
        $curso = CursoProgramado::find($request->curso_programado_id);
        $curso_original = Curso::find($curso->curso_id);
        return view('registro.index-descuento')
                ->with('curso',$curso)
                ->with('curso_programado',$curso)
                ->with('curso_original',$curso_original);
    }

    public function check(Request $request){
        $descuento = Descuento::where('clave', '=', $request->clave)
                                ->where('curso_programado_id', '=', $request->curso_programado_id)
                                ->where('activo', '=', 'si')
                                ->first();

        if(isset($descuento) == false){
            $descuento = New Descuento;
            $descuento->mensaje = "No se encontro la clave o ya expiro";
            return back()->with('error', 'No se encontro la clave o ya expiro');
        }else if($descuento->limite < 1){
            $descuento = New Descuento;
            $descuento->mensaje = "Descuentos agotados";
            return back()->with('limit', 'Descuentos agotados');
        }else{
            $descuento->limite = $descuento->limite - 1;
            $descuento->save();
        }

        return back()->with([
            'descuento' => $descuento->descuento,
        ]);
    }
}
