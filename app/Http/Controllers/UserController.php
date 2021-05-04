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

    public function index($active = "enable"){
        if($active == "enable")
            $users = User::with('roles')->get();
        elseif($active == "disable")
            $users = User::withoutGlobalScope('Activos')->with('roles')->where('activo','no')->get();
        //dd($users);
        return view('admin.users.index',compact('users','active'));
    }

    public function profile(Request $request){
        $user = User::with('roles')->find($request->id);
        $role = $user->roles->first();
        //\Log::debug(dd($role));
        return view('admin.users.profile')->with('role',$role);
    }

    public function edit($id){
        $user = User::find($id);
        $roles = Role::all()->pluck('name','id');
        return view('admin.users.edit',compact('user','roles'));
    }

    public function complete($id){
        $user = User::find($id);
        $roles = Role::all()->pluck('name','id');
        return view('alumno.complete',compact('user','roles'));
    }

    public function show($id){
        $user = User::withoutGlobalScope('Activos')->with('roles')->find($id);
        return view('admin.users.show',compact('user'));
    }

    public function verify($id){
        $user = User::withoutGlobalScope('Activos')->with('roles')->find($id);
        return view('admin.users.verify',compact('user'));
    }

    public function approve(Request $request){
        $user = User::find($request->id);
        $user->validado = "si";
        $user->save();
    }

    public function unapprove(Request $request){
        $user = User::find($request->id);
        $user->validado = "no";
        $user->save();
    }

    public function destroy($id){
        $user = User::withoutGlobalScope('Activos')->find($id);
        //dd($user);
        $estatus = ($user->activo == 'si')? 'desactivado' : 'activado';
        $user->activo = ($user->activo == 'si')? 'no' : 'si';
        $user->save();
        return redirect()->route('users.index')->with('success', 'El usuario ha sido '.$estatus);
    }

    public function update(Request $request, $id){
        $user = User::with('roles')->find($id);

        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->username = $request->usuario;
        $user->email = $request->email;

        $user->roles()->updateExistingPivot($user->roles[0]->id,['role_id' => $request->rol_id]);

        $user->save();
        return redirect()->route('users.index')->with('success', 'El usuario ha sido actualizado');
    }

    public function updateComplete(Request $request, $id){
        $user = User::with('roles')->find($id);

        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->fecha_sustentacion = $request->fecha_sustentacion;
        $user->telefono = $request->telefono;
        $user->folio = $request->folio;
        $user->universidad_procedencia = $request->universidad_procedencia;
        $user->especialidad = $request->especialidad;
        $user->foto = $this->fotoUpload($request, $user->foto);
        $user->documento_identificacion = $this->DocumentoUpload($request, $user->documento_identificacion);
        $user->pase_ingreso = $this->paseUpload($request,$user->pase_ingreso);
        //$user->roles()->updateExistingPivot($user->roles[0]->id,['role_id' => $request->rol_id]);

        $user->save();
        return redirect()->route(Auth::user()->rol[0]->slug);
    }

    public function fotoUpload(Request $request, $fileName)
    {
        $file = $request->file('foto');
        //\Log::debug(dd($file));
        if($request->imgEliminar == "si"){
            //\Log::debug(dd("file null"));
            return null;
        }
        if(is_null($file)){
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
        if($request->imgEliminar == "si"){
            //\Log::debug(dd("file null"));
            return null;
        }
        if(is_null($file)){
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
        $path = "documentos/identificaciones/".$file;
        return Storage::download($path);
    }

    public function paseUpload(Request $request, $fileName)
    {
        $file = $request->file('pase_ingreso');
        //\Log::debug(dd($file));
        if($request->imgEliminar == "si"){
            //\Log::debug(dd("file null"));
            return null;
        }
        if(is_null($file)){
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
        $path = "documentos/pases/".$file;
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
        $inscripciones = Inscripcion::with('CursoProgramado.Curso.Lecciones')->where('user_id',Auth::user()->id)->get();
        $arr = [];
        foreach($inscripciones as $inscripcion){
            $curso_programado = $inscripcion['CursoProgramado'];
            $contenido_programado = ContenidoProgramado::where('curso_programado_id',$curso_programado['id'])->first();
            if($contenido_programado){
                foreach($curso_programado['Curso']['Lecciones'] as $leccion){
                    $contenido = collect($contenido_programado->contenido)->where('id',$leccion->id)->first();
                    $fecha_inicial = $contenido['fecha_inicial'] ? $contenido['fecha_inicial'] : null;
                    /* $hora_inicial = $contenido['hora_inicial'] ? $contenido['hora_inicial'] : null; */
                    $fecha_final = $contenido['fecha_final'] ? $contenido['fecha_final'] : null;
                    /* $hora_final = $contenido['hora_final'] ? $contenido['hora_final'] : null; */
                    $arr[] =[
                        'title' => $curso_programado->curso->titulo,
                        'description' => $leccion->titulo,
                        'start' => date('D M d Y H:i:s',strtotime(str_replace('/','-',$fecha_inicial))),
                        'end' =>date('D M d Y H:i:s',strtotime(str_replace('/','-',$fecha_final))),
                        'className' => 'bg-purple',
                    ];
                }
            }
        }
       //    dd($arr);

        return view('alumno.calendario')->with('eventos',collect($arr)->toJson());
    }

    public function informacion(Request $request)
    {
        $datos = [
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'mensaje' => $request->mensaje
        ];

        $correo = config('mail.to_support');
        $mail = Mail::to($correo);
        $m = new InformacionEmail($datos);
        $mail->send($m);
    }
}



