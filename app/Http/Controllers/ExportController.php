<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportRequest;
use App\Models\Consent;
use App\Models\Lead;

class ExportController extends Controller
{
    // Page export : présentation du service et formulaire de demande
    public function index(string $locale)
    {
        return view('front.export', compact('locale'));
    }

    // Traitement du formulaire de demande d'export
    public function store(ExportRequest $request, string $locale)
    {
        $lead = Lead::create([
            'type'           => 'export',
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'country'        => $request->country,
            'message'        => $request->message,
            'vehicle_id'     => $request->vehicle_id ?? null,
            'current_status' => 'new',
        ]);

        // Enregistrement du consentement RGPD
        Consent::create([
            'lead_id'      => $lead->id,
            'consent_type' => 'form',
            'ip_address'   => $request->ip(),
            'user_agent'   => $request->userAgent(),
            'consented_at' => now(),
        ]);

        return redirect()
            ->route('export', ['locale' => $locale])
            ->with('success', __('messages.export_success'));
    }
}
