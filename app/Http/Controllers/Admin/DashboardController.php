<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use App\Models\Vehicle;

class DashboardController extends Controller
{
    // Tableau de bord : statistiques et activité récente
    public function index()
    {
        // 2 requêtes agrégées au lieu de 6 COUNT séparées
        $vehicleStats = Vehicle::selectRaw("
            SUM(CASE WHEN status = 'actif' THEN 1 ELSE 0 END) as actif,
            SUM(CASE WHEN status = 'vendu' THEN 1 ELSE 0 END) as vendu,
            COUNT(*) as total
        ")->first();

        $leadStats = Lead::selectRaw("
            SUM(CASE WHEN current_status = 'new' THEN 1 ELSE 0 END) as new_count,
            SUM(CASE WHEN current_status = 'in_progress' THEN 1 ELSE 0 END) as in_progress_count
        ")->whereNull('deleted_at')->first();

        $stats = [
            'vehicles_actif'    => (int) ($vehicleStats->actif ?? 0),
            'vehicles_sold'     => (int) ($vehicleStats->vendu ?? 0),
            'vehicles_total'    => (int) ($vehicleStats->total ?? 0),
            'leads_new'         => (int) ($leadStats->new_count ?? 0),
            'leads_in_progress' => (int) ($leadStats->in_progress_count ?? 0),
            'users_active'      => User::where('is_active', true)->count(),
        ];

        // 5 derniers leads reçus
        $recentLeads = Lead::with('vehicle')
            ->latest()
            ->take(5)
            ->get();

        // 5 derniers véhicules ajoutés
        $recentVehicles = Vehicle::with('mainImage', 'brand')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentLeads', 'recentVehicles'));
    }
}
