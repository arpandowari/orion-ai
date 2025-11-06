<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->guard('student')->check()) {
            return redirect()->route('student.login')->with('error', 'Please login to access this page');
        }

        return $next($request);
    }
}
