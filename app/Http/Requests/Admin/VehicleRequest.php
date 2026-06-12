<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            // ─── Informations de base ───────────────────────────────────────
            'brand_id'     => ['required', 'integer', 'exists:brands,id'],
            'model'        => ['required', 'string', 'max:100'],
            'version'      => ['nullable', 'string', 'max:100'],
            'vehicle_type' => ['required', 'in:cabriolet_roadster,suv_pickup,citadine,break,berline,monospace_minibus,sport_coupe,autre'],
            'condition'    => ['required', 'in:neuf,occasion'],
            'seller_type'  => ['required', 'in:concessionnaire,particulier,societe'],
            'year'         => ['required', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'mileage'      => ['required', 'integer', 'min:0'],
            'price'        => ['required', 'numeric', 'min:0'],
            'ancien_prix'  => ['nullable', 'numeric', 'min:0'],
            'price_type'   => ['nullable', 'string', 'max:50'],
            'seats'        => ['nullable', 'integer', 'min:1', 'max:100'],
            'doors'        => ['nullable', 'integer', 'min:1', 'max:10'],
            'sliding_door' => ['nullable', 'in:aucune,droite,gauche,deux_cotes'],
            'country'      => ['nullable', 'string', 'max:100'],
            'city'         => ['nullable', 'string', 'max:100'],
            'vin'          => ['nullable', 'string', 'max:17'],

            // ─── Données techniques ─────────────────────────────────────────
            'fuel_type'        => ['required', 'in:essence,diesel,electrique,bioethanol,hybride_essence,hybride_plug_in,gaz_naturel,hybride_rechargeable,gpl,autre'],
            'power_hp'         => ['nullable', 'integer', 'min:0'],
            'power_kw'         => ['nullable', 'integer', 'min:0'],
            'cylinder'         => ['nullable', 'integer', 'min:0'],
            'towing_capacity'  => ['nullable', 'integer', 'min:0'],
            'weight'           => ['nullable', 'integer', 'min:0'],
            'drive'            => ['nullable', 'in:4x4,traction_avant,propulsion'],
            'transmission'     => ['nullable', 'in:automatique,semi_automatique,manuelle'],
            'fuel_consumption' => ['nullable', 'numeric', 'min:0'],
            'emission_standard'=> ['nullable', 'string', 'max:50'],
            'dpf'              => ['boolean'],

            // ─── Extérieur / Intérieur ───────────────────────────────────────
            'exterior_color'    => ['nullable', 'string', 'max:100'],
            'tow_bar'           => ['nullable', 'in:aucune,fixe,detachable,pivotant'],
            'parking_radar'     => ['nullable', 'in:aucun,arriere,avant,camera_360'],
            'interior_color'    => ['nullable', 'string', 'max:100'],
            'interior_material' => ['nullable', 'string', 'max:100'],
            'air_conditioning'  => ['nullable', 'in:aucune,climatisation,climatisation_automatique'],

            // ─── État du véhicule ────────────────────────────────────────────
            'service_book'     => ['boolean'],
            'safety_compliant' => ['boolean'],
            'warranty'         => ['boolean'],
            'full_service'     => ['boolean'],
            'non_smoker'       => ['boolean'],
            'previous_owners'  => ['nullable', 'integer', 'min:0'],
            'ct_valid_days'    => ['nullable', 'integer', 'min:0'],

            // ─── Équipements JSON ────────────────────────────────────────────
            'exterior_extras'  => ['nullable', 'array'],
            'interior_extras'  => ['nullable', 'array'],

            // ─── Offre ───────────────────────────────────────────────────────
            'has_video'        => ['boolean'],
            'is_demonstration' => ['boolean'],
            'is_collaborator'  => ['boolean'],
            'is_collection'    => ['boolean'],
            'vat_status'       => ['nullable', 'in:recuperable,non_recuperable'],
            'description'      => ['nullable', 'string'],
            'status'           => ['required', 'in:actif,inactif,vendu'],
        ];
    }
}
