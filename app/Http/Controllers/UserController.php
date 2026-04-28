<?php

namespace App\Http\Controllers;

use App\Mail\SoporteTecnico;
use Illuminate\Http\Request;
use App\User;
use App\Models\Registro\Inscripcion;
use App\Models\Registro\ContenidoProgramado;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InformacionEmail;

class UserController extends Controller
{
    //************************************************************/
    //Funciones para la administracion de los usuarios regitrados

    public function index($active = "enable")
    {
        if ($active == "enable")
            $users = User::with('roles')->get();
        elseif ($active == "disable")
            $users = User::withoutGlobalScope('Activos')->with('roles')->where('activo', 'no')->get();
        elseif ($active == "blocked")
            $users = User::withoutGlobalScope('Activos')->with('roles')->where('is_blocked', 1)->get();
        //dd($users);
        return view('admin.users.index', compact('users', 'active'));
    }

    public function profile(Request $request)
    {
        $user = User::with('roles')->find($request->id);
        $role = $user->roles->first();
        //\Log::debug(dd($role));
        return view('admin.users.profile')->with('role', $role);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all()->pluck('name', 'id');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function complete($id)
    {
        $user = User::find($id);
        $roles = Role::all()->pluck('name', 'id');
        return view('alumno.complete', compact('user', 'roles'));
    }

    public function show($id)
    {
        $user = User::withoutGlobalScope('Activos')->with('roles')->find($id);
        return view('admin.users.show', compact('user'));
    }

    public function verify($id)
    {
        $user = User::withoutGlobalScope('Activos')->with('roles')->find($id);
        return view('admin.users.verify', compact('user'));
    }

    public function approve(Request $request)
    {
        $user = User::find($request->id);
        $user->validado = "si";
        $user->save();
    }

    public function unapprove(Request $request)
    {
        $user = User::find($request->id);
        $user->validado = "no";
        $user->save();
    }

    public function destroy($id)
    {
        $user = User::withoutGlobalScope('Activos')->find($id);
        //dd($user);
        $estatus = ($user->activo == 'si') ? 'desactivado' : 'activado';
        $user->activo = ($user->activo == 'si') ? 'no' : 'si';
        $user->save();
        return redirect()->route('users.index')->with('success', 'El usuario ha sido ' . $estatus);
    }

    public function update(Request $request, $id)
    {
        $nameRegex = 'regex:/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]+$/u';
        $request->validate([
            'nombre' => ['required', 'string', $nameRegex, 'max:255'],
            'apellido' => ['required', 'string', $nameRegex, 'max:255'],
            'usuario' => ['required', 'string', 'alpha_dash', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::with('roles')->find($id);

        $user->nombre = strip_tags($request->nombre);
        $user->apellido = strip_tags($request->apellido);
        $user->username = strip_tags($request->usuario);
        $user->email = strip_tags($request->email);

        $user->roles()->updateExistingPivot($user->roles[0]->id, ['role_id' => $request->rol_id]);

        $user->save();
        return redirect()->route('users.index')->with('success', 'El usuario ha sido actualizado');
    }

    public function updateComplete(Request $request, $id)
    {
        $nameRegex = 'regex:/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]+$/u';
        $request->validate([
            'nombre' => ['required', 'string', $nameRegex, 'max:255'],
            'apellido' => ['required', 'string', $nameRegex, 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'folio' => ['nullable', 'string', 'max:100'],
            'universidad_procedencia' => ['nullable', 'string', 'max:255'],
            'especialidad' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::with('roles')->find($id);

        $user->nombre = strip_tags($request->nombre);
        $user->apellido = strip_tags($request->apellido);
        $user->fecha_sustentacion = $request->fecha_sustentacion;
        $user->telefono = strip_tags($request->telefono);
        $user->folio = strip_tags($request->folio);
        $user->universidad_procedencia = strip_tags($request->universidad_procedencia);
        $user->especialidad = strip_tags($request->especialidad);
        $user->foto = $this->fotoUpload($request, $user->foto);
        $user->documento_identificacion = $this->DocumentoUpload($request, $user->documento_identificacion);
        $user->pase_ingreso = $this->paseUpload($request, $user->pase_ingreso);
        //$user->roles()->updateExistingPivot($user->roles[0]->id,['role_id' => $request->rol_id]);

        $user->save();
        return redirect()->route('alumno.home');
    }

    public function fotoUpload(Request $request, $fileName)
    {
        $file = $request->file('foto');
        //\Log::debug(dd($file));
        if ($request->imgEliminar == "si") {
            //\Log::debug(dd("file null"));
            return null;
        }
        if (is_null($file)) {
            return $fileName;
        }
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        // ]);
        $name = basename(Storage::put('images/usuarios', $file));
        return $name;
    }

    public function userPicture($file)
    {
        $storagePath = storage_path('app/images/usuarios/' . $file);
        return response()->file($storagePath);
    }

    public function DocumentoUpload(Request $request, $fileName)
    {
        $file = $request->file('documento_identificacion');
        //\Log::debug(dd($file));
        if ($request->imgEliminar == "si") {
            //\Log::debug(dd("file null"));
            return null;
        }
        if (is_null($file)) {
            return $fileName;
        }
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        // ]);
        $name = basename(Storage::put('documentos/identificaciones', $file));
        return $name;
    }

    public function documento($file)
    {
        $path = "documentos/identificaciones/" . $file;
        return Storage::download($path);
    }

    public function paseUpload(Request $request, $fileName)
    {
        $file = $request->file('pase_ingreso');
        //\Log::debug(dd($file));
        if ($request->imgEliminar == "si") {
            //\Log::debug(dd("file null"));
            return null;
        }
        if (is_null($file)) {
            return $fileName;
        }
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        // ]);
        $name = basename(Storage::put('documentos/pases', $file));
        return $name;
    }

    public function pase($file)
    {
        $path = "documentos/pases/" . $file;
        return Storage::download($path);
    }

    public function soporte()
    {
        return view('admin.users.soporte');
    }

    public function correoSoporte(Request $request)
    {
        $datos = [
            'asunto' => $request->asunto,
            'comentario' => $request->comentario,
            'usuario' => Auth::user()->nombre_completo,
        ];

        $mail = Mail::to(config('mail.to_support'));
        $soporte = new SoporteTecnico($datos);
        $mail->send($soporte);

        return back()->with('success', '¡Gracias!, en breve nos pondremos en
        contacto contigo');
    }

    public function calendario()
    {
        $inscripciones = Inscripcion::with(['CursoProgramado' => function ($q) {
            $q->withoutGlobalScope('Activos')->with('Curso.Lecciones');
        }])->where('user_id', Auth::user()->id)->get();
        $arr = [];
        foreach ($inscripciones as $inscripcion) {
            $curso_programado = $inscripcion['CursoProgramado'];

            if (!$curso_programado) {
                continue;
            }

            $contenido_programado = ContenidoProgramado::where('curso_programado_id', $curso_programado['id'])->first();
            if ($contenido_programado) {
                foreach ($curso_programado['Curso']['Lecciones'] as $leccion) {
                    $contenido = collect($contenido_programado->contenido)->where('id', $leccion->id)->first();
                    if ($contenido) {
                        $fecha_inicial = $contenido['fecha_inicial'] ? $contenido['fecha_inicial'] : null;
                        /* $hora_inicial = $contenido['hora_inicial'] ? $contenido['hora_inicial'] : null; */
                        $fecha_final = $contenido['fecha_final'] ? $contenido['fecha_final'] : null;
                        /* $hora_final = $contenido['hora_final'] ? $contenido['hora_final'] : null; */
                        $arr[] = [
                            'title' => $curso_programado->curso->titulo,
                            'description' => $leccion->titulo,
                            'start' => date('D M d Y H:i:s', strtotime(str_replace('/', '-', $fecha_inicial))),
                            'end' => date('D M d Y H:i:s', strtotime(str_replace('/', '-', $fecha_final))),
                            'className' => 'bg-purple',
                        ];
                    }
                }
            }
        }
        //    dd($arr);

        // Fetch valid calendars for these courses
        /* 
           Note: If there are multiple courses, showing multiple weekly images might be cluttery.
           But I should pass them to the view.
        */
        $course_ids = $inscripciones->pluck('CursoProgramado.curso_id')->unique();
        $current_date = now()->format('Y-m-d');

        $weekly_calendars = \App\ProgrammingCalendar::whereIn('curso_id', $course_ids)
            ->where('start_date', '<=', $current_date)
            ->where('end_date', '>=', $current_date)
            ->orderBy('position', 'asc')
            ->get();

        return view('alumno.calendario')
            ->with('eventos', collect($arr)->toJson())
            ->with('weekly_calendars', $weekly_calendars);
    }

    public function informacion(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'mensaje' => 'required|string',
        ]);

        $datos = [
            'nombre' => strip_tags($request->nombre),
            'email' => strip_tags($request->email),
            'telefono' => strip_tags($request->telefono),
            'mensaje' => strip_tags($request->mensaje)
        ];

        $correo = config('mail.to_support');
        $mail = Mail::to($correo);
        $m = new InformacionEmail($datos);
        $mail->send($m);
    }

    public function registerStrike(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $action = $request->input('action', 'Unknown');
            $details = $request->input('details', "Points: 10");
            $points = 10; // Default

            $isFeedbackMode = ($details === 'Feedback Mode');

            // Map actions to severity points (Threshold = 100)
            // High Intent (34 pts -> 3 strikes to block)
            if (in_array($action, ['Copy', 'Cut', 'Paste', 'PrintScreen', 'Save', 'View Source', 'Snipping Tool', 'Mac Screenshot'])) {
                $points = 34;
            }
            // Critical Intent (50 pts -> 2 strikes to block)
            elseif (in_array($action, ['DevTools', 'F12'])) {
                $points = 50;
            }
            // Medium Intent (20 pts -> 5 strikes to block)
            elseif ($action === 'Right Click') {
                $points = 20;
            }
            // Low Intent / Accidental (5 pts -> Warning + contribution to block)
            elseif (in_array($action, ['Shift', 'Restricted Key / Modifier'])) {
                $points = 5;
            }
            // Volume / Minimal Intent (0 pts)
            elseif (strpos($action, 'Volume') !== false) {
                $points = 0;
            }

            // --- IMMEDIATE BLOCK FOR FEEDBACK MODE ---
            if ($isFeedbackMode && $points > 0) {
                $points = 100;
                $details = "se tocaron teclas prohibidas en la retro y es un bloqueo grabe";
            }

            $user->strikes += $points;

            $status = 'warning';
            // Limit is notionally 100
            if ($user->strikes >= 100) {
                $user->is_blocked = true;
                $status = 'blocked';
            }

            $user->save();

            // Register History with points/details
            \App\Models\UserStrikeHistory::create([
                'user_id' => $user->id,
                'action' => $action,
                'details' => $details,
            ]);

            return response()->json([
                'status' => $status,
                'strikes' => $user->strikes,
                'max_strikes' => 100,
                'points_added' => $points
            ]);
        }
        return response()->json(['status' => 'error'], 400);
    }

    public function unlock($id)
    {
        $user = User::withoutGlobalScope('Activos')->find($id);

        if (!$user) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado.'], 404);
            }
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        $user->is_blocked = 0;
        $user->strikes = 0;
        $user->save();

        /* Mail::to($user->email)->send(new \App\Mail\AccountUnlocked($user)); */

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'El usuario ha sido desbloqueado exitosamente.']);
        }

        return redirect()->back()->with('success', 'El usuario ha sido desbloqueado exitosamente.');
    }

    /**
     * Clear MAC address for a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function clearMac($id)
    {
        $user = User::withoutGlobalScope('Activos')->find($id);

        if (!$user) {
             return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        $user->mac_address = null;
        $user->save();

        return redirect()->back()->with('success', 'La dirección MAC ha sido desvinculada exitosamente.');
    }
}
