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
        // check if user->with alumni is not null

        if (!$request->user()->alumni) {
            return response()->json([
                'message' => 'error',
                'errors' => 'Guess not allowed',
            ], 401);
        }
        
        return $next($request);
    }
}
