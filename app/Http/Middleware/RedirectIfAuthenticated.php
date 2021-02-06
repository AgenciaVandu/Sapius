<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            //return redirect('/home');

            if(Auth::user()->hasRole('admin'))
                return redirect("/admin");
            elseif(Auth::user()->hasRole('instructor'))
                return redirect("/instructor");
            elseif(Auth::user()->hasRole('alumno')){
                //Verificar si completo sus datos
                if(Auth::user()->fecha_sustentacion == "" || Auth::user()->fecha_sustentacion == null ||
                    Auth::user()->telefono == "" || Auth::user()->telefono == null ||
                    Auth::user()->foto == "" || Auth::user()->foto == null ||
                    Auth::user()->folio == "" || Auth::user()->folio == null ||
                    Auth::user()->universidad_procedencia == "" || Auth::user()->universidad_procedencia == null ||
                    Auth::user()->documento_identificacion == "" || Auth::user()->documento_identificacion == null ||
                    Auth::user()->pase_ingreso == "" || Auth::user()->pase_ingreso == null ||
                    Auth::user()->especialidad == "" || Auth::user()->especialidad == null){
                    return redirect("/alumno/users/".Auth::user()->id."/complete");
                }else{
                    return redirect("/alumno");
                }
            }
        }

        return $next($request);
    }
}
