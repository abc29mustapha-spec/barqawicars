<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $locales  = ['de', 'fr', 'en'];

        // Cache 1h : évite un full-scan à chaque hit bot/crawler
        $vehicles = Cache::remember('sitemap_vehicles', 3600, fn () =>
            Vehicle::actif()
                ->select('id', 'brand_id', 'model', 'version', 'updated_at')
                ->with(['brand:id,name', 'mainImage:id,vehicle_id,image_path'])
                ->latest('updated_at')
                ->get()
        );

        $staticRoutes = [
            'home'           => ['changefreq' => 'daily',   'priority' => '1.0'],
            'vehicles.index' => ['changefreq' => 'daily',   'priority' => '0.9'],
            'export'         => ['changefreq' => 'weekly',  'priority' => '0.8'],
            'about'          => ['changefreq' => 'monthly', 'priority' => '0.6'],
            'contact'        => ['changefreq' => 'monthly', 'priority' => '0.6'],
            'legal'          => ['changefreq' => 'yearly',  'priority' => '0.2'],
            'terms'          => ['changefreq' => 'yearly',  'priority' => '0.2'],
            'privacy'        => ['changefreq' => 'yearly',  'priority' => '0.2'],
            'landing.import_germany_france' => ['changefreq' => 'monthly', 'priority' => '0.8'],
            'landing.used_cars_germany'     => ['changefreq' => 'monthly', 'priority' => '0.8'],
            'landing.car_export_germany'    => ['changefreq' => 'monthly', 'priority' => '0.8'],
            'landing.bmw_germany'           => ['changefreq' => 'monthly', 'priority' => '0.7'],
            'landing.audi_germany'          => ['changefreq' => 'monthly', 'priority' => '0.7'],
            'landing.mercedes_germany'      => ['changefreq' => 'monthly', 'priority' => '0.7'],
        ];

        // Date stable pour les pages statiques (évite que lastmod change à chaque requête)
        $staticLastmod = Carbon::parse(config('app.seo_lastmod', '2026-06-09'))->toAtomString();

        $urlGroups = [];

        // ── Pages statiques ───────────────────────────────────────────────
        foreach ($staticRoutes as $routeName => $meta) {
            $locs = [];
            foreach ($locales as $locale) {
                $locs[$locale] = route($routeName, ['locale' => $locale]);
            }
            $urlGroups[] = array_merge($meta, [
                'locs'    => $locs,
                'lastmod' => $staticLastmod,
                'image'   => null,
            ]);
        }

        // ── Fiches véhicules ──────────────────────────────────────────────
        foreach ($vehicles as $vehicle) {
            $locs = [];
            foreach ($locales as $locale) {
                $locs[$locale] = route('vehicles.show', ['locale' => $locale, 'id' => $vehicle->id]);
            }

            $image = null;
            if ($vehicle->mainImage) {
                $image = [
                    'loc'   => Storage::url($vehicle->mainImage->image_path),
                    'title' => trim("{$vehicle->brand?->name} {$vehicle->model} {$vehicle->version}"),
                ];
            }

            $urlGroups[] = [
                'locs'       => $locs,
                'lastmod'    => $vehicle->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority'   => '0.9',
                'image'      => $image,
            ];
        }

        $content = view('sitemap', ['urlGroups' => $urlGroups, 'locales' => $locales])->render();

        return response($content, 200, [
            'Content-Type'  => 'application/xml',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
