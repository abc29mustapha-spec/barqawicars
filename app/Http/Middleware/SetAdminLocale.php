<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetAdminLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = session('admin_locale', 'fr');

        if (!in_array($locale, ['fr', 'de', 'en'])) {
            $locale = 'fr';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
