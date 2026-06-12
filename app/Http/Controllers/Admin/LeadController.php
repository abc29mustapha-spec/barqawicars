<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadStatusHistory;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LeadController extends Controller
{
    // Liste des leads avec filtres
    public function index(Request $request)
    {
        $query = Lead::with(['vehicle.brand', 'vehicle.mainImage', 'assignedTo']);

        // Commercials only see leads explicitly assigned to them
        if (!auth()->user()->isAdmin()) {
            $query->where('assigned_to', auth()->id());
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('current_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $leads = $query->latest()->paginate(20)->withQueryString();

        // Only admins see the full list of commercials for re-assignment
        $commercials = auth()->user()->isAdmin()
            ? User::where('is_active', true)->orderBy('name')->get()
            : collect();

        return view('admin.leads.index', compact('leads', 'commercials'));
    }

    // Détail d'un lead
    public function show(Lead $lead)
    {
        // Commercial can only view leads assigned to them
        if (!auth()->user()->isAdmin() && $lead->assigned_to !== auth()->id()) {
            abort(403, 'Accès non autorisé à ce lead.');
        }

        $lead->load(['vehicle.mainImage', 'vehicle.brand', 'assignedTo', 'statusHistory', 'consents']);
        $commercials = auth()->user()->isAdmin()
            ? User::where('is_active', true)->orderBy('name')->get()
            : collect();

        return view('admin.leads.show', compact('lead', 'commercials'));
    }

    // Mise à jour d'un lead (assignation de commercial)
    public function update(Request $request, Lead $lead)
    {
        Gate::authorize('update', $lead);

        $request->validate([
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $lead->update(['assigned_to' => $request->assigned_to]);
        AuditService::log('update', 'lead', $lead->id);

        return back()->with('success', 'Lead mis à jour.');
    }

    // Mise à jour du statut d'un lead avec commentaire
    public function updateStatus(Request $request, Lead $lead)
    {
        Gate::authorize('update', $lead);

        $request->validate([
            'status'  => ['required', 'in:new,in_progress,closed,cancelled'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $lead->update(['current_status' => $request->status]);

        // Enregistrer dans l'historique
        LeadStatusHistory::create([
            'lead_id'    => $lead->id,
            'status'     => $request->status,
            'comment'    => $request->comment,
            'created_at' => now(),
        ]);

        AuditService::log('update', 'lead', $lead->id);

        return back()->with('success', 'Statut mis à jour.');
    }

    // Suppression (soft delete) d'un lead
    public function destroy(Lead $lead)
    {
        Gate::authorize('delete', $lead);

        $lead->delete();
        AuditService::log('delete', 'lead', $lead->id);

        return redirect()
            ->route('admin.leads.index')
            ->with('success', 'Lead supprimé.');
    }

    // Anonymisation RGPD (Art. 17) — admin uniquement, irréversible
    public function anonymize(Lead $lead)
    {
        Gate::authorize('anonymize', $lead);

        if ($lead->anonymized_at) {
            return back()->withErrors(['error' => __('admin.already_anonymized')]);
        }

        $lead->anonymize();
        AuditService::log('anonymize', 'lead', $lead->id);

        return back()->with('success', __('admin.lead_anonymized_ok'));
    }
}
