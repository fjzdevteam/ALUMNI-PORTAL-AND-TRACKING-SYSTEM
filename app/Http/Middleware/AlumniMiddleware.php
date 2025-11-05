<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AlumniMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('alumni.401');
        }

        if (strtolower(Auth::user()->role) !== 'alumni') {
            return redirect()->route('alumni.403');
        }

        return $next($request);
    }
}
