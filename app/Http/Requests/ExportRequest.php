<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255'],
            'phone'      => ['required', 'string', 'max:30'],
            'country'    => ['required', 'string', 'max:100'],
            'vehicle_id' => ['nullable', 'integer', 'exists:vehicles,id'],
            'message'    => ['nullable', 'string', 'max:2000'],
            'consent'    => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'consent.accepted' => 'Vous devez accepter les conditions pour envoyer la demande.',
            'phone.required'   => 'Le numéro de téléphone est obligatoire pour les demandes export.',
            'country.required' => 'Le pays de destination est obligatoire.',
        ];
    }
}
