<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class guestOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->alumni) {
            return response()->json([
                'message' => 'error',
                'errors' => 'Only guest allowed',
                'data' => !$request->user()->alumni
            ], 401);
        }

        return $next($request);
    }
}
