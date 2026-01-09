<?php

namespace App\Http\Middleware;

use Closure;

class CheckBlocked
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
        if (auth()->check() && auth()->user()->is_blocked) {
            // Check if current route is NOT the locked page to avoid infinite loop
            if ($request->route()->getName() !== 'alumno.locked' && 
                $request->route()->getName() !== 'alumno.block-account' && 
                $request->route()->getName() !== 'alumno.register-strike' &&
                $request->route()->getName() !== 'examen.finalizar-imprevisto') {
                
                return redirect()->route('alumno.locked');
            }
        }
        return $next($request);
    }
}
