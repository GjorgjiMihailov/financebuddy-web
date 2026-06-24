<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // Email alert при production грешки (не за 404/403/422 HTTP exceptions)
        $exceptions->report(function (\Throwable $e): void {
            if (! app()->environment('production') || $e instanceof HttpExceptionInterface) {
                return;
            }
            try {
                \Illuminate\Support\Facades\Mail::raw(
                    '[' . get_class($e) . '] ' . $e->getMessage()
                    . "\n\nURL: " . request()->fullUrl()
                    . "\nFajl: " . $e->getFile() . ':' . $e->getLine()
                    . "\n\nStack trace:\n" . $e->getTraceAsString(),
                    fn ($m) => $m->to(env('ADMIN_EMAIL', 'financebuddy.mk@gmail.com'))
                                 ->subject('[FinanceBuddy.mk] Production Error — ' . now()->format('d.m.Y H:i'))
                );
            } catch (\Throwable) {
                // не фрлај ако mail config не е поставен
            }
        });
    })->create();
