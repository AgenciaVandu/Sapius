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
        if (Auth::check()) {
            $user = Auth::user();

            // Solo aplicar validación si es alumno
            if ($user->hasRole('alumno')) {
                // Prioridad de obtención de MAC:
                // 1. Encabezado directo (Electron)
                // 2. Campo de formulario (Proceso de Login)
                // 3. Sesión (Navegación web persistente)
                $rawMac = $request->header('X-Sapius-MAC') 
                               ?: $request->input('mac_address') 
                               ?: session('sapius_mac');

                // Normalización agresiva (solo hexadecimal)
                $providedMac = $this->normalize($rawMac);
                $userMac = $this->normalize($user->mac_address);

                // LOG DE DEBUG (Solo para alumnos)
                Log::info("[MAC_DEBUG] User ID: {$user->id} | Provided: '{$rawMac}' (Norm: '{$providedMac}') | DB MAC: '{$user->mac_address}' (Norm: '{$userMac}')");

                // Si no tiene MAC registrada o el valor proporcionado no coincide
                if (empty($userMac) || $providedMac !== $userMac) {
                    
                    Log::warning("[MAC_FAIL] Acceso denegado para User ID: {$user->id}. Mismatch detectado.");

                    // Si la petición es AJAX o API, retornar JSON
                    if ($request->expectsJson()) {
                        return response()->json([
                            'error' => 'Unauthorized Device',
                            'message' => 'Este dispositivo no está vinculado a tu cuenta.'
                        ], 403);
                    }

                    // De lo contrario, desloguear y mandar a una vista de error o login
                    Auth::logout();
                    return redirect()->route('login')->withErrors([
                        'mac_error' => 'Acceso denegado: Esta cuenta ya está vinculada a otro equipo. Sapius solo permite el acceso desde el dispositivo registrado originalmente.'
                    ]);
                }
            }
        }

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
