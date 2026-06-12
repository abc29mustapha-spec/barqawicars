<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'phone'      => ['nullable', 'string', 'max:30'],
            'country'    => ['nullable', 'string', 'max:100'],
            'subject'    => ['nullable', 'string', 'max:255'],
            'type'       => ['nullable', 'in:contact,quote,test_drive,export,whatsapp'],
            'vehicle_id' => ['nullable', 'integer', 'exists:vehicles,id'],
            'message'    => ['required', 'string', 'min:3', 'max:2000'],
            'consent'    => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'consent.accepted' => 'Vous devez accepter les conditions pour envoyer le formulaire.',
            'message.min'      => 'Votre message doit contenir au moins 3 caractères.',
        ];
    }
}
