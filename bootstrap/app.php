<?php

use App\Http\Middleware\RedirectOldUrl;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Torchlight\Middleware\RenderTorchlight;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(RedirectOldUrl::class);
        $middleware->append(RenderTorchlight::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
