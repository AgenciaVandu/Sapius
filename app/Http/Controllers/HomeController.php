<?php

namespace App\Http\Controllers;

use App\Models\Cursos\Category;
use App\Models\Landing\Pride;
use App\Models\Landing\Slide;
use App\Models\Landing\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro\CursoProgramado;
use App\Models\Registro\Inscripcion;
use App\Reviews;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

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
            $query->with('Curso')->where('fecha_inicio_venta', '<=', date('Y-m-d H:i:s'))
                ->where('fecha_fin', '>=', date('Y-m-d H:i:s'));
        })->with('CursoProgramado.Curso')->where('user_id', Auth::user()->id)->get();

        //dd($cursos[0]->CursoProgramado()->get());
        if (count($cursos)) return view('alumno.home')->with('cursos', $cursos);

        return view('alumno.home')->with('cursos', $cursos);
        /* return $this->cursosDisponibles(); */
    }

    public function cursosDisponibles()
    {
        $category = Category::where('name', 'Cursos')->first();
        $cursos = CursoProgramado::with('Curso')
            ->whereDoesntHave('Inscritos', function ($query) {
                $query->where('users.id', Auth::user()->id);
            })
            ->where('fecha_inicio_venta', '<=', date('Y-m-d H:i:s'))
            ->where('fecha_fin_venta', '>=', date('Y-m-d H:i:s'))->get();


        return view('alumno.cursos')->with('cursos', $cursos)->with('category', $category);
    }

    public function guiasDisponibles()
    {
        $category = Category::where('name', 'Guias')->first();
        $cursos = CursoProgramado::with('Curso')
            ->whereDoesntHave('Inscritos', function ($query) {
                $query->where('users.id', Auth::user()->id);
            })
            ->where('fecha_inicio_venta', '<=', date('Y-m-d H:i:s'))
            ->where('fecha_fin_venta', '>=', date('Y-m-d H:i:s'))->get();


        return view('alumno.guias')->with('cursos', $cursos)->with('category', $category);
    }

    public function simuladoresDisponibles()
    {
        $category = Category::where('name', 'Simuladores')->first();
        $cursos = CursoProgramado::with('Curso')
            ->whereDoesntHave('Inscritos', function ($query) {
                $query->where('users.id', Auth::user()->id);
            })
            ->where('fecha_inicio_venta', '<=', date('Y-m-d H:i:s'))
            ->where('fecha_fin_venta', '>=', date('Y-m-d H:i:s'))->get();


        return view('alumno.simuladores')->with('cursos', $cursos)->with('category', $category);
    }

    public function admin()
    {
        $cursos = CursoProgramado::with('Curso')/* ->where('fecha_inicio_venta', '<=', date('Y-m-d H:i:s')) */
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
        $slides = Slide::where('section', 'LIKE', 'slider-index')->orderBy('position', 'asc')->get();
        $prides = Pride::orderBy('position', 'asc')->get();
        $teachers = Teacher::orderBy('position', 'asc')->get();
        return view('admin.configuracion.index', compact('slides', 'prides','teachers'));
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



    //teachers

    public function uploadTeacher(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image4' => 'required|max:2048',
        ]);

        try {
            $url = $request->file('image4')->store('teachers', 'public');

            Teacher::create([
                'img' => $url,
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Teacher uploaded successfully.');
        } catch (\Exception $e) {
            Log::error('Error uploading slide: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to upload slide.');
        }
    }

    public function updateTeacher(Request $request, Teacher $teacher)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($request->image5) {
            $url = $request->file('image5')->store('teachers', 'public');
            $teacher->update([
                'img' => $url,
                'name' => $request->name,
                'description' => $request->description,
            ]);
            return redirect()->back()->with('success', 'Teacher uploaded successfully.');
        } else {
            $teacher->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            return redirect()->back()->with('success', 'Teacher uploaded successfully.');
        }
    }

    public function deleteTeacher(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->back()->with('success', 'Pride Delete successfully.');
    }


    public function tuOpinion(){
        $reviwews = Reviews::where('user_id', Auth::user()->id)->get();
        return view('alumno.tu-opinion')->with('reviews', $reviwews);
    }

    public function storeOpinion(Request $request){
        $request->validate([
            'name' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:100',
        ]);

        // Lista extendida de palabras prohibidas
        $badWords = [
            'puta', 'puto', 'pendejo', 'pendeja', 'mierda', 'chingar', 'chingada', 'chingado',
            'verga', 'cabrón', 'cabrona', 'culero', 'culera', 'imbécil', 'idiota', 'estúpido', 'estúpida',
            'zorra', 'perra', 'maricón', 'marica', 'mamón', 'mamona', 'pinche', 'asco',
            'malo', 'pésimo', 'horrible', 'asqueroso', 'terrible', 'basura', 'fraude', 'falso',
            'estafa', 'engaño', 'mentira', 'timar', 'robo', 'inútil', 'decepción', 'engañoso',
            'aburrido', 'mediocre', 'desastre', 'pobre', 'deficiente', 'inservible', 'vergonzoso',
            'curso malo', 'curso pésimo', 'curso horrible', 'curso basura', 'profesor malo',
            'profesor pésimo', 'no sirve', 'no aprendes', 'malísimo', 'pérdida de tiempo','culo','pene'
        ];

        $comment = strtolower($request->comment);
        $containsBadWord = false;

        foreach ($badWords as $word) {
            if (strpos($comment, $word) !== false) {
                $containsBadWord = true;
                break;
            }
        }

        if ($containsBadWord) {
            $visible = false;
            $rating = 0;
        } else {
            $rating = $request->rating;
            $visible = $request->rating >= 4 ? true : false;
        }

        Reviews::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'rating' => $rating,
            'comment' => $request->comment,
            'visible' => $visible,
        ]);

        return redirect()->route('tu.opinion')->with('success', 'Opinion created successfully.');
    }

    public function triggerOverdueReminders()
    {
        try {
            Artisan::call('reminders:overdue-lessons');
            return redirect()->back()->with('success', 'Recordatorios de lecciones atrasadas enviados correctamente.');
        } catch (\Exception $e) {
            Log::error('Error triggering overdue reminders: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al enviar recordatorios: ' . $e->getMessage());
        }
    }
}
