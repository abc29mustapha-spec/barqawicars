<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    // Langues supportées par l'application
    public const SUPPORTED_LOCALES = ['fr', 'en', 'de'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        // Fallback vers la locale par défaut si invalide
        if (!in_array($locale, self::SUPPORTED_LOCALES, true)) {
            $locale = config('app.locale', 'de');
        }

        App::setLocale($locale);
        session(['locale' => $locale]);

        return $next($request);
    }
}
