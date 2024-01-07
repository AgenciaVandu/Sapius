<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Rules\ValidRecaptcha;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function redirectPath()
    {
        //dd(auth()->user()->roles());
        if(auth()->user()->hasRole('admin'))
            return "/admin";
        elseif(auth()->user()->hasRole('instructor'))
            return "/instructor";
        elseif(auth()->user()->hasRole('alumno'))
            //Verificar si completo sus datos
            if(auth()->user()->fecha_sustentacion == "" || auth()->user()->fecha_sustentacion == null ||
                auth()->user()->telefono == "" || auth()->user()->telefono == null ||
                auth()->user()->foto == "" || auth()->user()->foto == null ||
                auth()->user()->folio == "" || auth()->user()->folio == null ||
                auth()->user()->universidad_procedencia == "" || auth()->user()->universidad_procedencia == null ||
                auth()->user()->documento_identificacion == "" || auth()->user()->documento_identificacion == null ||
                auth()->user()->pase_ingreso == "" || auth()->user()->pase_ingreso == null ||
                auth()->user()->especialidad == "" || auth()->user()->especialidad == null){
                return "/alumno/users/".auth()->user()->id."/complete";
            }else{
                return "/alumno";
            }
    }

    /**
     * Envía la respuesta después de que el usuario se autentifique.
     * Elimina el resto de sesiones de este usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        //$this->validateLogin($request);
        $request->session()->regenerate();
        $previous_session = Auth::User()->session_id;
        if ($previous_session) {
            Session::getHandler()->destroy($previous_session);
        }

        Auth::user()->session_id = Session::getId();
        Auth::user()->save();
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    protected function validateLogin(Request $request)
    {
        /* $request->validate([
            'g-recaptcha-response' => ['required', new ValidRecaptcha],
        ],$this->messages()); */
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'Selccciona la casilla No Soy un Robot.',
        ];
    }

}