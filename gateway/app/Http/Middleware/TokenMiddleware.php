<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('health')) {
            return $next($request);
        }
        $required = 'Bearer ' . env('TOKEN_REQUIRED', 'secret123');
        if ($request->header('Authorization') !== $required) {
            return response()->json(['message'=>'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
