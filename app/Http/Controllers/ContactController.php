<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Consent;
use App\Models\Lead;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Page contact avec formulaire
    public function index(string $locale)
    {
        return view('front.contact', compact('locale'));
    }

    // Traitement du formulaire de contact
    public function store(ContactRequest $request, string $locale)
    {
        // Use the type sent from the vehicle page (quote, test_drive, export, contact)
        $type = in_array($request->type, ['contact', 'quote', 'test_drive', 'export', 'whatsapp'])
            ? $request->type
            : 'contact';

        $lead = Lead::create([
            'type'           => $type,
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

        // Redirect back to vehicle page if request came from one
        if ($lead->vehicle_id) {
            return redirect()
                ->route('vehicles.show', ['locale' => $locale, 'id' => $lead->vehicle_id])
                ->with('success', __('messages.contact_success'));
        }

        return redirect()
            ->route('contact', ['locale' => $locale])
            ->with('success', __('messages.contact_success'));
    }

    // Traçage d'un clic WhatsApp — lead anonyme, WhatsApp s'ouvre côté client
    public function trackWhatsApp(Request $request, string $locale, Vehicle $vehicle)
    {
        $ref         = $vehicle->vin ? 'VIN : ' . $vehicle->vin : 'Réf. #' . $vehicle->id;
        $vehicleName = trim(($vehicle->brand?->name ?? '') . ' ' . $vehicle->model);
        $price       = number_format($vehicle->price, 0, ',', ' ') . ' €';
        $vehicleUrl  = route('vehicles.show', ['locale' => $locale, 'id' => $vehicle->id]);

        Lead::create([
            'type'           => 'whatsapp',
            'vehicle_id'     => $vehicle->id,
            'current_status' => 'new',
            'message'        => implode("\n", [
                '📱 Demande WhatsApp',
                '',
                "Véhicule : {$vehicleName} ({$vehicle->year})",
                "Prix : {$price}",
                $ref,
                "URL : {$vehicleUrl}",
            ]),
        ]);

        return response()->json(['success' => true]);
    }
}
