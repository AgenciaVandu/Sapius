<?php

namespace App\Http\Controllers;

use App\Models\Landing\Pride;
use App\Models\Landing\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro\CursoProgramado;
use App\Models\Registro\Inscripcion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        $cursos = Inscripcion::whereHas('CursoProgramado', function ($query) {
            $query->with('Curso')->where('fecha_inicio', '<=', date('Y-m-d H:i:s'))
                ->where('fecha_fin', '>=', date('Y-m-d H:i:s'));
        })->with('CursoProgramado.Curso')->where('user_id', Auth::user()->id)->get();

        //dd($cursos[0]->CursoProgramado()->get());
        if (count($cursos)) return view('alumno.home')->with('cursos', $cursos);

        return $this->cursosDisponibles();
    }

    public function cursosDisponibles()
    {
        $cursos = CursoProgramado::with('Curso')
            ->whereDoesntHave('Inscritos', function ($query) {
                $query->where('users.id', Auth::user()->id);
            })
            ->where('fecha_inicio', '<=', date('Y-m-d H:i:s'))
            ->where('fecha_fin', '>=', date('Y-m-d H:i:s'))->get();

        return view('alumno.cursos')->with('cursos', $cursos);
    }

    public function admin()
    {
        $cursos = CursoProgramado::with('Curso')->where('fecha_inicio', '<=', date('Y-m-d H:i:s'))
            ->where('fecha_fin', '>=', date('Y-m-d H:i:s'))->get();
        return view('admin.home')->with('cursos', $cursos);
    }

    public function instructor()
    {
        $cursos = CursoProgramado::with('Curso')
            ->where('fecha_inicio', '<=', date('Y-m-d H:i:s'))
            ->where('fecha_fin', '>=', date('Y-m-d H:i:s'))
            ->where('user_id', Auth::user()->id)->get();
        return view('instructor.home')->with('cursos', $cursos);
    }

    public function configuracion()
    {
        $slides = Slide::where('section', 'LIKE', 'slider-index')->get();
        $prides = Pride::paginate(5);
        return view('admin.configuracion.index', compact('slides', 'prides'));
    }

    public function uploadslide(Request $request)
    {
        $request->validate([
            'image' => 'required|max:2048',
        ]);

        try {
            $url = $request->file('image')->store('slider-index', 'public');

            Slide::create([
                'img' => $url,
                'section' => 'slider-index'
            ]);

            return redirect()->back()->with('success', 'Slide uploaded successfully.');
        } catch (\Exception $e) {
            Log::error('Error uploading slide: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to upload slide.');
        }
    }

    public function deleteSlide(Slide $slide)
    {
        $slide->delete();
        return redirect()->back();
    }


    public function uploadpride(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'text' => 'required',
            'text2' => 'required',
            'image2' => 'required|max:2048',
        ]);

        try {
            $url = $request->file('image2')->store('prides', 'public');

            Pride::create([
                'img' => $url,
                'name' => $request->name,
                'text' => $request->text,
                'text2' => $request->text2,
            ]);

            return redirect()->back()->with('success', 'Pride uploaded successfully.');
        } catch (\Exception $e) {
            Log::error('Error uploading slide: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to upload slide.');
        }
    }

    public function updatePride(Request $request, Pride $pride)
    {

        $request->validate([
            'name' => 'required',
            'text' => 'required',
            'text2' => 'required',
        ]);

        if ($request->image3) {
            $url = $request->file('image3')->store('prides', 'public');
            $pride->update([
                'img' => $url,
                'name' => $request->name,
                'text' => $request->text,
                'text2' => $request->text2,
            ]);
            return redirect()->back()->with('success', 'Pride uploaded successfully.');
        } else {
            $pride->update([
                'name' => $request->name,
                'text' => $request->text,
                'text2' => $request->text2,
            ]);
            return redirect()->back()->with('success', 'Pride uploaded successfully.');
        }
    }

    public function deletePride(Pride $pride)
    {
        $pride->delete();
        return redirect()->back()->with('success', 'Pride Delete successfully.');
    }
}