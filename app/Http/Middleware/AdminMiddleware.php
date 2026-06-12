<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Non connecté → page de connexion
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        // Compte désactivé → déconnexion forcée
        if (!Auth::user()->is_active) {
            Auth::logout();
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Votre compte est désactivé. Contactez l\'administrateur.']);
        }

        return $next($request);
    }
}
