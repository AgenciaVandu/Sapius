<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class RestrictMobileAccess
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
        $agent = new Agent();

        $isMobile = $agent->isMobile();
        $isTablet = $agent->isTablet();
        $platform = strtolower($agent->platform());
        $device = strtolower($agent->device());
        $userAgent = strtolower($request->header('User-Agent'));

        // Permitir plataformas que claramente son de escritorio
        $desktopPlatforms = ['windows', 'mac', 'linux', 'ubuntu'];

        // Si la plataforma es una de escritorio, se permite el acceso
        foreach ($desktopPlatforms as $desktopPlatform) {
            if (str_contains($platform, $desktopPlatform) || str_contains($userAgent, $desktopPlatform)) {
                return $next($request);
            }
        }

        // Si no es plataforma de escritorio y es móvil o tablet, se bloquea
        if ($isMobile || $isTablet) {
            return response()->view('errors.no_access');
        }

        return $next($request);
    }
}