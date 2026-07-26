<?php

namespace App\Http\Controllers\Cursos;

use App\Models\Cursos\MaterialPdf;
use App\Models\Cursos\AlumnoPdfRespuesta;
use App\Models\Cursos\Leccion;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MaterialInteractivePdfController extends Controller
{
    /**
     * Display a listing of interactive PDFs for a given lesson.
     */
    public function index(Request $request)
    {
        $leccion = Leccion::findOrFail($request->leccion_id);
        $curso = Curso::findOrFail($leccion->curso_id);
        $modulo = Leccion::findOrFail($leccion->leccion_id);
        $materials = MaterialPdf::where('leccion_id', $leccion->id)->get();

        return view('material_pdfs.index', compact('leccion', 'curso', 'modulo', 'materials'));
    }

    /**
     * Show the form for creating a new interactive PDF.
     */
    public function create(Request $request)
    {
        $leccion = Leccion::findOrFail($request->leccion_id);
        $curso = Curso::findOrFail($leccion->curso_id);
        $modulo = Leccion::findOrFail($leccion->leccion_id);

        return view('material_pdfs.create', compact('leccion', 'curso', 'modulo'));
    }

    /**
     * Store a newly created interactive PDF in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'leccion_id' => 'required|exists:lecciones,id',
            'titulo' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:20480', // limit to 20MB
        ]);

        $file = $request->file('file');
        $fileName = basename(Storage::put('files/interactive_pdfs', $file));

        $material = MaterialPdf::create([
            'leccion_id' => $request->leccion_id,
            'titulo' => $request->titulo,
            'file_path' => $fileName,
            'fields_config' => []
        ]);

        $leccion = Leccion::findOrFail($request->leccion_id);

        return redirect()->route('admin.material-pdfs.index', ['leccion_id' => $leccion->id])
                         ->with('success', 'PDF interactivo subido exitosamente.');
    }

    /**
     * Show the editor to configure editable fields.
     */
    public function edit($id)
    {
        $material = MaterialPdf::findOrFail($id);
        $leccion = Leccion::findOrFail($material->leccion_id);
        $curso = Curso::findOrFail($leccion->curso_id);
        $modulo = Leccion::findOrFail($leccion->leccion_id);

        return view('material_pdfs.editor', compact('material', 'leccion', 'curso', 'modulo'));
    }

    /**
     * Save the configuration of fields (X, Y, Page, Name, W, H).
     */
    public function saveConfig(Request $request, $id)
    {
        $material = MaterialPdf::findOrFail($id);
        $material->fields_config = $request->input('fields_config', []);
        $material->save();

        return response()->json(['success' => true, 'message' => 'Configuración guardada correctamente.']);
    }

    /**
     * Display the PDF for the student to fill.
     */
    public function showAlumno($id)
    {
        $material = MaterialPdf::findOrFail($id);
        $leccion = Leccion::findOrFail($material->leccion_id);
        
        // Find existing response for student
        $respuesta = AlumnoPdfRespuesta::where('user_id', Auth::id())
                                        ->where('material_pdf_id', $material->id)
                                        ->first();

        return view('material_pdfs.viewer', compact('material', 'leccion', 'respuesta'));
    }

    /**
     * Display the PDF with student answers for review by admin/instructor.
     */
    public function showAdminReview($id, $user_id)
    {
        $material = MaterialPdf::findOrFail($id);
        $leccion = Leccion::findOrFail($material->leccion_id);
        $alumno = \App\User::findOrFail($user_id);
        
        // Find existing response for student
        $respuesta = AlumnoPdfRespuesta::where('user_id', $user_id)
                                        ->where('material_pdf_id', $material->id)
                                        ->first();

        return view('material_pdfs.viewer_admin', compact('material', 'leccion', 'respuesta', 'alumno'));
    }


    /**
     * Save/update student answers.
     */
    public function saveAnswers(Request $request, $id)
    {
        $material = MaterialPdf::findOrFail($id);
        
        $respuesta = AlumnoPdfRespuesta::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'material_pdf_id' => $material->id
            ],
            [
                'respuestas' => $request->input('respuestas', [])
            ]
        );

        return response()->json(['success' => true, 'message' => 'Tus respuestas han sido guardadas.']);
    }

    /**
     * Download or stream the raw PDF file.
     */
    public function downloadRaw($id)
    {
        $material = MaterialPdf::findOrFail($id);
        $path = 'files/interactive_pdfs/' . $material->file_path;

        if (!Storage::exists($path)) {
            abort(404, 'Archivo no encontrado.');
        }

        return Storage::download($path, $material->titulo . '.pdf');
    }

    /**
     * Delete the resource.
     */
    public function destroy($id)
    {
        $material = MaterialPdf::findOrFail($id);
        $leccion_id = $material->leccion_id;
        
        // Delete physical file
        Storage::delete('files/interactive_pdfs/' . $material->file_path);
        $material->delete();

        return redirect()->route('admin.material-pdfs.index', ['leccion_id' => $leccion_id])
                         ->with('success', 'PDF interactivo eliminado.');
    }
}
