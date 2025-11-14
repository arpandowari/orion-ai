<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Force HTTPS in production, but not on localhost
        $isLocalhost = in_array($request->getHost(), ['localhost', '127.0.0.1', '::1']);
        
        if (app()->environment('production') && !$request->secure() && !$isLocalhost) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
