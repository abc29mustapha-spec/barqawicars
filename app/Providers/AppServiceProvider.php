<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }

        // 5 tentatives/min par combinaison email+IP — bloque les attaques par dictionnaire
        // sans pénaliser un utilisateur légitime qui se trompe 1 ou 2 fois
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->input('email') . '|' . $request->ip());
        });

        // 3 soumissions/min par IP pour les formulaires publics — laisse de la marge
        // pour un double-clic accidentel mais bloque les robots de spam de leads
        RateLimiter::for('public-forms', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });
    }
}
