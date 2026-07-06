<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VerifyMacAddress
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
        // Se ha deshabilitado la verificación obligatoria de dirección MAC en el servidor
        return $next($request);
    }

    /**
     * Normaliza la MAC suprimiendo cualquier caracter que no sea hexadecimal.
     */
    private function normalize($mac)
    {
        return strtolower(preg_replace('/[^a-fA-F0-9]/', '', $mac));
    }
}
