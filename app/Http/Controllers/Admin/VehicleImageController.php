<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleImageController extends Controller
{
    // Upload d'une ou plusieurs images pour un véhicule
    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'images'   => ['required', 'array', 'max:20'],
            'images.*' => ['image', 'mimes:jpeg,png,webp', 'max:5120'], // 5 Mo max par image
        ]);

        $hasMain = $vehicle->images()->where('is_main', true)->exists();
        $position = $vehicle->images()->max('position') ?? 0;

        foreach ($request->file('images') as $file) {
            $path = $file->store('vehicles', 'public');
            $position++;

            VehicleImage::create([
                'vehicle_id' => $vehicle->id,
                'image_path' => $path,
                'is_main'    => !$hasMain, // La première image uploadée devient principale
                'position'   => $position,
            ]);

            $hasMain = true;
        }

        $vehicle->update(['has_photos' => true]);

        return back()->with('success', count($request->file('images')) . ' image(s) ajoutée(s).');
    }

    // Suppression d'une image
    public function destroy(Vehicle $vehicle, VehicleImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $wasMain = $image->is_main;
        $image->delete();

        // Définir la prochaine image comme principale si nécessaire
        if ($wasMain) {
            $vehicle->images()->orderBy('position')->first()?->update(['is_main' => true]);
        }

        // Mettre à jour le flag has_photos
        if ($vehicle->images()->count() === 0) {
            $vehicle->update(['has_photos' => false]);
        }

        return back()->with('success', 'Image supprimée.');
    }

    // Définir une image comme image principale
    public function setMain(Vehicle $vehicle, VehicleImage $image)
    {
        // Retirer le flag de toutes les images du véhicule
        $vehicle->images()->update(['is_main' => false]);
        $image->update(['is_main' => true]);

        return back()->with('success', 'Image principale mise à jour.');
    }

    // Réorganiser les images (tri drag-and-drop)
    public function reorder(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'order'   => ['required', 'array'],
            'order.*' => ['integer', 'exists:vehicle_images,id'],
        ]);

        foreach ($request->order as $position => $imageId) {
            $vehicle->images()->where('id', $imageId)->update(['position' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }
}
