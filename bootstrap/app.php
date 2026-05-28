<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 🔒 CONFIGURACIÓN REQUERIDA PARA RAILWAY: Confía en los proxies para activar HTTPS
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin'      => \App\Http\Middleware\AdminOnly::class,
            'superadmin' => \App\Http\Middleware\SuperAdmin::class,
        ]);

        // 🔥 OBLIGA AL NÚCLEO DEL FRAMEWORK A ENVIAR A LOS USUARIOS A /PANEL
        $middleware->redirectUsersTo('/panel');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

