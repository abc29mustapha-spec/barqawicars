<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    // Page À propos : histoire, équipe, chiffres clés
    public function index(string $locale)
    {
        return view('front.about', compact('locale'));
    }
}
