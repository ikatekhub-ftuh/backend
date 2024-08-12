<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class bancheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->is_banned) {
            return response()->json([
                'success' => false,
                'message' => 'You are banned',
                'reason' => $request->user()->ban_reason,
            ], 401);
        }

        return $next($request);
    }
}
