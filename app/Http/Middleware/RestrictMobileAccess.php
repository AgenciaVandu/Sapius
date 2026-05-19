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
        $userAgent = strtolower($request->header('User-Agent'));

        // 1. Block if the front-end has set the cookie indicating this is an iPad simulating a Mac (touch support + Macintosh headers)
        if ($request->hasCookie('is_touch_device') && (str_contains($platform, 'mac') || str_contains($platform, 'os x') || str_contains($userAgent, 'macintosh'))) {
            return response()->view('errors.no_access');
        }

        // 2. Direct string checks for classic mobile/tablet keywords in User-Agent (contingency for older or custom agents)
        if (str_contains($userAgent, 'ipad') || str_contains($userAgent, 'android') || str_contains($userAgent, 'iphone') || str_contains($userAgent, 'ipod') || str_contains($userAgent, 'mobile')) {
            return response()->view('errors.no_access');
        }

        // 3. Fallback to library detection if clearly identified as mobile or tablet
        if ($isMobile || $isTablet) {
            // Safeguard: Allow touchscreen Windows/Linux desktop laptops to pass
            $desktopPlatforms = ['windows', 'linux'];
            if (!in_array($platform, $desktopPlatforms)) {
                return response()->view('errors.no_access');
            }
        }

        return $next($request);
    }
}