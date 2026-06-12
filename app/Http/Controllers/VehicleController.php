<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // Catalogue de véhicules avec filtres et pagination
    public function index(Request $request, string $locale)
    {
        $query = Vehicle::actif()->with('mainImage', 'brand');

        // ─── Filtres ────────────────────────────────────────────────
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('brand', fn($b) => $b->where('name', 'like', "%{$search}%"))
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('version', 'like', "%{$search}%");
            });
        }
        if ($request->filled('brand')) {
            $query->where('brand_id', (int) $request->brand);
        }
        if ($request->filled('model')) {
            $query->where('model', $request->model);
        }
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }
        if ($request->filled('vehicle_type')) {
            $query->where('vehicle_type', $request->vehicle_type);
        }
        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }
        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }
        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->price_max);
        }
        if ($request->filled('mileage_min')) {
            $query->where('mileage', '>=', (int) $request->mileage_min);
        }
        if ($request->filled('mileage_max')) {
            $query->where('mileage', '<=', (int) $request->mileage_max);
        }
        if ($request->filled('year_min')) {
            $query->where('year', '>=', (int) $request->year_min);
        }
        if ($request->filled('year_max')) {
            $query->where('year', '<=', (int) $request->year_max);
        }
        if ($request->filled('vat_status')) {
            $query->where('vat_status', $request->vat_status);
        }
        if ($request->filled('color')) {
            $color = $request->color;
            $query->where(function ($q) use ($color) {
                $q->where('exterior_color', $color)
                  ->orWhere('exterior_color', $color . '_mate')
                  ->orWhere('exterior_color', $color . '_metallique');
            });
        }

        // ─── Tri ─────────────────────────────────────────────────────
        match ($request->input('sort', 'latest')) {
            'price_asc'   => $query->orderBy('price', 'asc'),
            'price_desc'  => $query->orderBy('price', 'desc'),
            'mileage_asc' => $query->orderBy('mileage', 'asc'),
            'year_desc'   => $query->orderBy('year', 'desc'),
            default       => $query->latest(),
        };

        $vehicles = $query->paginate(8)->withQueryString();

        // Données pour les selects de filtres
        $brands = \App\Models\Brand::orderBy('name')->get();

        // ── SEO dynamique : title + description selon les filtres actifs ─────
        $brandName = $request->filled('brand')
            ? $brands->firstWhere('id', (int) $request->brand)?->name
            : null;

        $fuelMap = [
            'essence'         => 'filters.fuel_essence',
            'diesel'          => 'filters.fuel_diesel',
            'electrique'      => 'filters.fuel_electric',
            'hybride_essence' => 'filters.fuel_hybrid',
            'hybride_plug_in' => 'filters.fuel_plugin',
            'gpl'             => 'filters.fuel_gpl',
        ];
        $fuelLabel = ($request->filled('fuel_type') && isset($fuelMap[$request->fuel_type]))
            ? __($fuelMap[$request->fuel_type], [], $locale)
            : null;

        $transMap = [
            'automatique'      => 'filters.trans_auto',
            'manuelle'         => 'filters.trans_manual',
            'semi_automatique' => 'filters.trans_semi',
        ];
        $transLabel = ($request->filled('transmission') && isset($transMap[$request->transmission]))
            ? __($transMap[$request->transmission], [], $locale)
            : null;

        $vtypeLabel = $request->filled('vehicle_type')
            ? __('vtype.' . $request->vehicle_type, [], $locale)
            : null;

        $condLabel = $request->filled('condition')
            ? __('seo.condition_' . $request->condition, [], $locale)
            : null;

        // Title : [Marque] [Type] [Carburant] [Transmission] [Condition] – BARQAWI
        $titleParts = array_filter([$brandName, $vtypeLabel, $fuelLabel, $transLabel, $condLabel]);
        $catalogSeoTitle = count($titleParts) > 0
            ? implode(' ', $titleParts) . ' – BARQAWI'
            : null;

        // Description : count + label composite
        $descLabel = trim(implode(' ', array_filter([$brandName, $vtypeLabel, $fuelLabel, $condLabel])));
        $catalogSeoDescription = $catalogSeoTitle
            ? __('seo.catalog_desc_filtered', ['count' => $vehicles->total(), 'label' => $descLabel], $locale)
            : null;

        return view('front.vehicles.index', compact(
            'vehicles', 'brands', 'locale',
            'catalogSeoTitle', 'catalogSeoDescription'
        ));
    }

    // Fiche détaillée d'un véhicule
    public function show(string $locale, int $id)
    {
        $vehicle = Vehicle::actif()
            ->with(['images', 'mainImage', 'brand'])
            ->findOrFail($id);

        // Véhicules similaires : même marque ou même type
        $similarVehicles = Vehicle::actif()
            ->where('id', '!=', $vehicle->id)
            ->where(function ($q) use ($vehicle) {
                $q->where('brand_id', $vehicle->brand_id)
                  ->orWhere('vehicle_type', $vehicle->vehicle_type);
            })
            ->with('mainImage', 'brand')
            ->take(3)
            ->get();

        return view('front.vehicles.show', compact('vehicle', 'similarVehicles', 'locale'));
    }
}
