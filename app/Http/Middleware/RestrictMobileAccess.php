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

        // 🧪 Log para pruebas
        \Log::info('User Agent: ' . $request->header('User-Agent'));
        \Log::info([
            'platform' => $platform,
            'device' => $device,
            'isMobile' => $isMobile,
            'isTablet' => $isTablet,
        ]);

        // Primero, bloquea si es claramente un dispositivo móvil o tablet
        if ($isMobile || $isTablet) {
            // Solo permite si el sistema operativo es Windows o Mac y el navegador es de escritorio
            $desktopPlatforms = ['windows', 'macintosh', 'linux']; // Linux puede causar falsos positivos, opcional
            $desktopBrowsers = ['chrome', 'firefox', 'edge', 'safari', 'opera'];

            $platformAllowed = in_array($platform, $desktopPlatforms);
            $browserAllowed = false;

            foreach ($desktopBrowsers as $browser) {
                if (str_contains($userAgent, $browser)) {
                    $browserAllowed = true;
                    break;
                }
            }

            if (!($platformAllowed && $browserAllowed)) {
                return response()->view('errors.no_access');
            }
        }

        return $next($request);
    }
}