<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Empêche l'affichage en iframe sur un domaine tiers (clickjacking)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Empêche les navigateurs de deviner le type MIME (MIME-sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Contrôle les informations envoyées dans l'en-tête Referer
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // CSP appliqué uniquement en production
        // Alpine.js v3 nécessite 'unsafe-eval' (utilise new Function() pour évaluer les expressions x-data)
        // Google Analytics nécessite googletagmanager.com en script-src et google-analytics.com en connect-src
        if (app()->isProduction()) {
            $response->headers->set('Content-Security-Policy', implode('; ', [
                "default-src 'self'",
                "script-src 'self' 'unsafe-eval' https://www.googletagmanager.com",
                "style-src 'self' 'unsafe-inline'",
                "img-src 'self' data: blob:",
                "font-src 'self' data:",
                "connect-src 'self' https://www.google-analytics.com https://region1.google-analytics.com",
                "frame-ancestors 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "object-src 'none'",
            ]));
        }

        return $response;
    }
}
