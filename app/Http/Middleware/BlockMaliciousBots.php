<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BlockMaliciousBots
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
        $ip = $request->ip();

        // 1. Immediately check if the incoming IP is already banned via Cache.
        if (Cache::has("ban-{$ip}")) {
            return response('Access Denied (Banned)', 403);
        }

        // 2. Inspect the incoming URI (lowercase format).
        $uri = strtolower($request->getRequestUri());

        $maliciousSignatures = [
            '.env',
            'xmlrpc',
            'aws/',
            '.json',
            'config',
            'credentials',
            'bugbounty',
            'responsible-disclosure'
        ];

        foreach ($maliciousSignatures as $signature) {
            if (strpos($uri, $signature) !== false) {
                // 3. Store bad IP in the server Cache for 24 hours (1440 minutes).
                Cache::put("ban-{$ip}", true, 1440);

                Log::warning("BlockMaliciousBots: Banned IP {$ip} for attempting to access malicious URI: {$request->getRequestUri()}");

                return response('Not Allowed', 403);
            }
        }

        return $next($request);
    }
}
