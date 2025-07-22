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

        $isMobileOrTablet = $agent->isMobile() || $agent->isTablet();
        $platform = $agent->platform();

        // Sistemas operativos que suelen estar en laptops/PCs
        $allowedDesktopPlatforms = ['Windows', 'Macintosh', 'Linux'];

        // Si es móvil o tablet Y no está en la lista de plataformas permitidas, se bloquea
        if ($isMobileOrTablet && !in_array($platform, $allowedDesktopPlatforms)) {
            return response()->view('errors.no_access');
        }

        return $next($request);
    }
}