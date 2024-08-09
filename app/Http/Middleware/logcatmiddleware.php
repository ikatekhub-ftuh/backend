<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class logcatmiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$params): Response
    {
        // go to storage/logs/laravel.log
        Log::info(implode(',', $params).' | '.'accessed category'.' | '.$request->method().' | '.$request->ip().' | '.$request->url().' | '.$request->header('user-agent'));
        
        return $next($request);
    }
}
