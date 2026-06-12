<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('vehicles')->orderBy('name')->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:brands,name'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,webp,svg', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }

        Brand::create($data);

        return redirect()->route('admin.marques.index')->with('success', 'Marque créée avec succès.');
    }

    public function edit(Brand $marque)
    {
        return view('admin.brands.edit', compact('marque'));
    }

    public function update(Request $request, Brand $marque)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:brands,name,' . $marque->id],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,webp,svg', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            if ($marque->logo) {
                Storage::disk('public')->delete($marque->logo);
            }
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }

        $marque->update($data);

        return redirect()->route('admin.marques.index')->with('success', 'Marque mise à jour.');
    }

    public function destroy(Brand $marque)
    {
        if ($marque->logo) {
            Storage::disk('public')->delete($marque->logo);
        }

        $marque->delete();

        return redirect()->route('admin.marques.index')->with('success', 'Marque supprimée.');
    }
}
