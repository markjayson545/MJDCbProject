<?php

use App\Http\Middleware\DownForMaintenanceMW;
use App\Http\Middleware\MiddlewareOne;
use App\Http\Middleware\MiddlewareTwo;
use App\Http\Middleware\PromotionMW;
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
        // Global Middleware
        $middleware->append([
            PromotionMW::class,
        ]);
        // One MiddleWare
        $middleware->alias(['maintenance' => DownForMaintenanceMW::class]);
        // Group MiddleWare
        $middleware->group('group_middleware', [
            MiddlewareOne::class,
            MiddlewareTwo::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
