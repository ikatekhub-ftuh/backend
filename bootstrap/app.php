<?php

use App\Http\Middleware\bancheck;
use App\Http\Middleware\loggermiddleware;
use App\Http\Middleware\returnjsonmiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            'logcat' => loggermiddleware::class,
            'returnjson' => returnjsonmiddleware::class,
        ]);
        
        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\isAdmin::class,
            'isNotBanned' => bancheck::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
    })->create();
