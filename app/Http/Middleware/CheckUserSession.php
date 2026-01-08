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

                return redirect()->route('login')->withErrors([
                    'session_expired' => 'Tu sesión fue cerrada porque iniciaste sesión en otro dispositivo o navegador.',
                ]);
            }
        }

        return $next($request);
    }
}
