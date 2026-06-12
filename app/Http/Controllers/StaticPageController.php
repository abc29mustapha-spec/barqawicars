<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class StaticPageController extends Controller
{
    public function legal(string $locale): View
    {
        return view('front.legal', compact('locale'));
    }

    public function terms(string $locale): View
    {
        return view('front.terms', compact('locale'));
    }

    public function privacy(string $locale): View
    {
        return view('front.privacy', compact('locale'));
    }

    public function importFromGermany(string $locale): View
    {
        return view('front.landing.import-car-from-germany-to-france', compact('locale'));
    }

    public function usedCarsGermany(string $locale): View
    {
        return view('front.landing.used-cars-germany', compact('locale'));
    }

    public function carExportGermany(string $locale): View
    {
        return view('front.landing.car-export-germany', compact('locale'));
    }

    public function bmwGermany(string $locale): View
    {
        return view('front.landing.bmw-germany', compact('locale'));
    }

    public function audiGermany(string $locale): View
    {
        return view('front.landing.audi-germany', compact('locale'));
    }

    public function mercedesGermany(string $locale): View
    {
        return view('front.landing.mercedes-germany', compact('locale'));
    }
}
