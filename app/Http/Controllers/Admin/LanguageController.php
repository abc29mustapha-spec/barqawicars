<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request): RedirectResponse
    {
        $locale = in_array($request->lang, ['fr', 'de', 'en']) ? $request->lang : 'fr';
        session(['admin_locale' => $locale]);

        return back();
    }
}
