<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Review;
use App\Models\Vehicle;

class HomeController extends Controller
{
    public function index(string $locale)
    {
        $featuredVehicles = Vehicle::actif()
            ->with('mainImage', 'brand')
            ->latest()
            ->take(8)
            ->get();

        // Counts per vehicle type for the type section
        $typeCounts = Vehicle::actif()
            ->selectRaw('vehicle_type, count(*) as total')
            ->groupBy('vehicle_type')
            ->pluck('total', 'vehicle_type');

        // Top brands by vehicle count
        $topBrands = Brand::withCount(['vehicles' => fn($q) => $q->where('status', 'actif')->whereNull('deleted_at')])
            ->having('vehicles_count', '>', 0)
            ->orderByDesc('vehicles_count')
            ->take(8)
            ->get();

        // All brands for the search form
        $brands = Brand::orderBy('name')->get();

        // Avis clients publiés (max 6, pour la section home + AggregateRating)
        $reviews = Review::published()->latest('published_at')->take(6)->get();

        return view('front.home', compact('featuredVehicles', 'typeCounts', 'topBrands', 'brands', 'locale', 'reviews'));
    }
}
