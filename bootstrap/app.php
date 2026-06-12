<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Headers de sécurité HTTP sur toutes les réponses web
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeadersMiddleware::class,
        ]);

        // Alias des middlewares personnalisés
        $middleware->alias([
            'admin'           => \App\Http\Middleware\AdminMiddleware::class,
            'admin-only'      => \App\Http\Middleware\AdminOnlyMiddleware::class,
            'setLocale'       => \App\Http\Middleware\SetLocale::class,
            'setAdminLocale'  => \App\Http\Middleware\SetAdminLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Redirige avec un message d'erreur lisible au lieu d'une page 429 brute
        $exceptions->render(function (ThrottleRequestsException $_, Request $request) {
            if ($request->is('admin/connexion')) {
                return redirect()->route('admin.login')
                    ->withErrors(['email' => 'Trop de tentatives de connexion. Veuillez patienter 1 minute avant de réessayer.'])
                    ->withInput($request->only('email'));
            }
            if ($request->is('*/contact') || $request->is('*/export')) {
                return back()
                    ->withErrors(['throttle' => 'Trop de soumissions. Veuillez patienter quelques secondes avant de réessayer.'])
                    ->withInput();
            }
        });
    })->create();
