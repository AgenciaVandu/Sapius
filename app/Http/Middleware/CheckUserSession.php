<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Si la sesión actual no coincide con la guardada en BD
            if ($user->session_id !== Session::getId()) {
                Auth::logout();

                return redirect()->route('login')->withErrors([
                    'session_expired' => 'Tu sesión fue cerrada porque iniciaste sesión en otro dispositivo o navegador.',
                ]);
            }
        }

        return $next($request);
    }
}
