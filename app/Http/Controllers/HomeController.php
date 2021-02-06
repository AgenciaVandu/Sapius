<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro\CursoProgramado;
use App\Models\Registro\Inscripcion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cursos = Inscripcion::whereHas('CursoProgramado', function($query){
            $query->with('Curso')->where('fecha_inicio','<=',date('Y-m-d H:i:s'))
            ->where('fecha_fin','>=',date('Y-m-d H:i:s'));
        })->with('CursoProgramado.Curso')->where('user_id',Auth::user()->id)->get();

        //dd($cursos[0]->CursoProgramado()->get());
        if(count($cursos)) return view('alumno.home')->with('cursos',$cursos);

        return $this->cursosDisponibles();
    }

    public function cursosDisponibles(){
        $cursos = CursoProgramado::with('Curso')
            ->whereDoesntHave('Inscritos', function($query) {
                $query->where('users.id', Auth::user()->id);
            })
            ->where('fecha_inicio','<=',date('Y-m-d H:i:s'))
            ->where('fecha_fin','>=',date('Y-m-d H:i:s'))->get();

        return view('alumno.cursos')->with('cursos',$cursos);
    }

    public function admin()
    {
        $cursos = CursoProgramado::with('Curso')->where('fecha_inicio','<=',date('Y-m-d H:i:s'))
            ->where('fecha_fin','>=',date('Y-m-d H:i:s'))->get();
        return view('admin.home')->with('cursos',$cursos);
    }

    public function instructor()
    {
        $cursos = CursoProgramado::with('Curso')
            ->where('fecha_inicio','<=',date('Y-m-d H:i:s'))
            ->where('fecha_fin','>=',date('Y-m-d H:i:s'))
            ->where('user_id',Auth::user()->id)->get();
        return view('instructor.home')->with('cursos',$cursos);
    }
}
