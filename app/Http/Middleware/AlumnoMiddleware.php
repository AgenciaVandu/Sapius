<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AlumnoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Si no está autenticado en la sesión web tradicional, pero se envía un Token Bearer
        if (!Auth::check() && $request->bearerToken()) {
            if ($user = Auth::guard('api')->user()) {
                Auth::setUser($user);
            }
        }

        if(Auth::check() && Auth::user()->hasRole('alumno'))
        return $next($request);

        return redirect("/");
    }
}
