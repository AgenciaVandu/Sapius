<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use App\ProgrammingCalendar;
use App\Models\Cursos\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgrammingCalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($curso_id)
    {
        $curso = Curso::findOrFail($curso_id);
        $calendars = ProgrammingCalendar::where('curso_id', $curso_id)
            ->orderBy('start_date', 'asc')
            ->orderBy('position', 'asc')
            ->get();

        return view('registro.calendars.index', compact('curso', 'calendars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'images' => 'required',
            'images.*' => 'file|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'group_name' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('images')) {
            $lastPosition = ProgrammingCalendar::where('curso_id', $request->curso_id)->max('position') ?? 0;

            foreach ($request->file('images') as $image) {
                $lastPosition++;
                $path = $image->store('calendars', 'public');
                ProgrammingCalendar::create([
                    'curso_id' => $request->curso_id,
                    'image_path' => $path,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'group_name' => $request->group_name,
                    'position' => $lastPosition,
                ]);
            }
        }

        return redirect()->route('admin.programming.calendar.index', ['curso_id' => $request->curso_id])
            ->with('success', 'Calendarios agregados correctamente.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:programming_calendars,id',
            'order.*.position' => 'required|integer',
        ]);

        foreach ($request->order as $item) {
            ProgrammingCalendar::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $calendar = ProgrammingCalendar::findOrFail($id);
        $curso_id = $calendar->curso_id;

        // Delete file from storage
        Storage::disk('public')->delete($calendar->image_path);

        $calendar->delete();

        return redirect()->route('admin.programming.calendar.index', ['curso_id' => $curso_id])
            ->with('success', 'Calendario eliminado correctamente.');
    }
}
