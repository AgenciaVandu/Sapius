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

    if ($agent->isMobile() || $agent->isTablet()) {
        return response()->view('errors.no_access');
    }

    return $next($request);
}
}
