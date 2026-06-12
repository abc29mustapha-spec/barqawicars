<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleRequest;
use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Services\AuditService;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // Liste des véhicules avec recherche et filtres
    public function index(Request $request)
    {
        $query = Vehicle::withTrashed()->with('mainImage', 'brand');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('brand', fn($b) => $b->where('name', 'like', "%{$search}%"))
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('vin', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $vehicles = $query->latest()->paginate(20)->withQueryString();

        return view('admin.vehicles.index', compact('vehicles'));
    }

    // Formulaire de création d'un véhicule
    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.vehicles.create', compact('brands'));
    }

    // Enregistrement d'un nouveau véhicule
    public function store(VehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());

        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => ['image', 'mimes:jpeg,png,webp', 'max:5120'],
            ]);
            $position = 1;
            foreach ($request->file('images') as $file) {
                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'image_path' => $file->store('vehicles', 'public'),
                    'is_main'    => $position === 1,
                    'position'   => $position++,
                ]);
            }
            $vehicle->update(['has_photos' => true]);
        }

        AuditService::log('create', 'vehicle', $vehicle->id);

        return redirect()
            ->route('admin.vehicules.show', $vehicle)
            ->with('success', 'Véhicule créé avec succès.');
    }

    // Affichage du détail d'un véhicule (backoffice)
    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['images', 'leads.statusHistory']);
        return view('admin.vehicles.show', compact('vehicle'));
    }

    // Formulaire d'édition d'un véhicule
    public function edit(Vehicle $vehicle)
    {
        $vehicle->load('images');
        $brands = Brand::orderBy('name')->get();
        return view('admin.vehicles.edit', compact('vehicle', 'brands'));
    }

    // Mise à jour d'un véhicule
    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());
        AuditService::log('update', 'vehicle', $vehicle->id);

        return redirect()
            ->route('admin.vehicules.show', $vehicle)
            ->with('success', 'Véhicule mis à jour avec succès.');
    }

    // Suppression logique (soft delete)
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        AuditService::log('delete', 'vehicle', $vehicle->id);

        return redirect()
            ->route('admin.vehicules.index')
            ->with('success', 'Véhicule supprimé.');
    }
}
