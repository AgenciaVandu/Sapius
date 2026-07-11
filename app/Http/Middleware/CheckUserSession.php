<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CheckUserSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Si la sesión actual no coincide con la guardada en BD
            if ($user->session_id !== Session::getId()) {
                Log::warning('CheckUserSession: Session mismatch. User ID: ' . $user->id . '. DB Session: ' . $user->session_id . '. Current Session: ' . Session::getId());
                Auth::logout();

                $message = 'Tu sesión fue cerrada porque iniciaste sesión en otro dispositivo o navegador.';

                // Detectar si el usuario estaba en un examen o prueba
                $referer = $request->header('referer');
                if ($request->is('*examen*') || $request->is('*prueba*') || ($referer && (str_contains($referer, 'examen') || str_contains($referer, 'prueba')))) {
                    $message = 'Se cerró tu sesión por abrir una sesión simultánea en otro dispositivo. Esta actividad se registra como posible intento de duplicidad de accesos durante la evaluación.';
                }

                return redirect()->route('login')->withErrors([
                    'session_expired' => $message,
                ]);
            }
        }

        return $next($request);
    }
}
