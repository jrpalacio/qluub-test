<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsClient
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isClient()) {
            return $next($request);
        }
        abort(403, 'No autorizado.');
    }
}
