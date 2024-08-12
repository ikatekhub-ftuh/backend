<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class noGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->is_admin || $request->user()->alumni) {
            return $next($request);
        }

        return response()->json([
            'message' => 'error',
            'errors' => 'Guess not allowed',
            'data' => $request->user()->alumni
        ], 401);
    }
}
