<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);
        $middleware->validateCsrfTokens(except: ['Student']);

        // Global middleware
        $middleware->append(
            \App\Http\Middleware\PromotionMW::class
        );

        // Group middleware
        $middleware->group('group_middleware', [
            \App\Http\Middleware\Middleware1::class,
            \App\Http\Middleware\Middleware2::class,
        ]);

        // Route-level aliases (middleware)
        $middleware->alias([
            'maintenance' => \App\Http\Middleware\DownforMaintenanceMW::class,
            'login.session' => \App\Http\Middleware\loginMW::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();