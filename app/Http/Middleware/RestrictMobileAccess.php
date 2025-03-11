<?php

namespace App\Http\Middleware;

use Closure;

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
        // Detect device type
        $agent = $request->header('User-Agent');

        // List of mobile and tablet keywords
        $mobileDevices = ['iPhone', 'iPad', 'Android', 'webOS', 'BlackBerry', 'Windows Phone', 'Mobile'];

        foreach ($mobileDevices as $device) {
            if (stripos($agent, $device) !== false) {
                // Redirect or abort access for mobile devices
                return response()->view('errors.no_access');
            }
        }

        return $next($request);
    }
}