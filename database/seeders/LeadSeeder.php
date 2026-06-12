<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\LeadStatusHistory;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $commercial = User::where('email', 'commercial@barqawi.ch')->first();
        $admin      = User::where('email', 'admin@barqawi.ch')->first();
        $vehicles   = Vehicle::all();

        if ($vehicles->isEmpty()) return;

        $leads = [
            [
                'type' => 'quote', 'name' => 'Jean-Pierre Müller', 'email' => 'jp.muller@gmail.com',
                'phone' => '+41 79 123 45 67', 'country' => 'CH',
                'message' => 'Bonjour, je suis intéressé par ce véhicule. Pouvez-vous me faire une offre ferme ?',
                'current_status' => 'in_progress', 'assigned_to' => $commercial?->id,
                'vehicle_index' => 0,
            ],
            [
                'type' => 'test_drive', 'name' => 'Sophie Durand', 'email' => 'sophie.durand@hotmail.com',
                'phone' => '+41 76 234 56 78', 'country' => 'CH',
                'message' => 'Je voudrais faire un essai routier samedi matin si possible.',
                'current_status' => 'new', 'assigned_to' => null,
                'vehicle_index' => 1,
            ],
            [
                'type' => 'contact', 'name' => 'Ahmed Benali', 'email' => 'a.benali@outlook.com',
                'phone' => '+33 6 12 34 56 78', 'country' => 'FR',
                'message' => 'Bonjour, est-ce que le véhicule est encore disponible ? Quels sont les délais de livraison ?',
                'current_status' => 'new', 'assigned_to' => null,
                'vehicle_index' => 2,
            ],
            [
                'type' => 'export', 'name' => 'Karim El Fassi', 'email' => 'k.elfassi@gmail.com',
                'phone' => '+212 6 61 23 45 67', 'country' => 'MA',
                'message' => 'Je souhaite exporter ce véhicule au Maroc. Quels sont les documents nécessaires et le prix export ?',
                'current_status' => 'in_progress', 'assigned_to' => $admin?->id,
                'vehicle_index' => 4,
            ],
            [
                'type' => 'quote', 'name' => 'Maria Gonzalez', 'email' => 'maria.g@yahoo.es',
                'phone' => '+34 6 12 34 56 78', 'country' => 'ES',
                'message' => 'Bonjour, je cherche un SUV familial. Ce modèle correspond à mes critères. Quel est votre meilleur prix ?',
                'current_status' => 'closed', 'assigned_to' => $commercial?->id,
                'vehicle_index' => 3,
            ],
            [
                'type' => 'contact', 'name' => 'Thomas Keller', 'email' => 't.keller@bluewin.ch',
                'phone' => '+41 78 345 67 89', 'country' => 'CH',
                'message' => 'Est-il possible d\'avoir l\'historique complet du véhicule et les rapports d\'inspection ?',
                'current_status' => 'new', 'assigned_to' => null,
                'vehicle_index' => 5,
            ],
            [
                'type' => 'test_drive', 'name' => 'Isabelle Perret', 'email' => 'i.perret@gmail.com',
                'phone' => '+41 79 456 78 90', 'country' => 'CH',
                'message' => 'Je suis très intéressée. Puis-je venir voir le véhicule en concession cette semaine ?',
                'current_status' => 'in_progress', 'assigned_to' => $commercial?->id,
                'vehicle_index' => 8,
            ],
            [
                'type' => 'export', 'name' => 'Youssef Trabelsi', 'email' => 'y.trabelsi@gmail.com',
                'phone' => '+216 22 345 678', 'country' => 'TN',
                'message' => 'Export Tunisie, besoin devis complet avec frais de douane et transport.',
                'current_status' => 'cancelled', 'assigned_to' => $admin?->id,
                'vehicle_index' => 7,
            ],
        ];

        foreach ($leads as $data) {
            $vehicleIndex = $data['vehicle_index'];
            unset($data['vehicle_index']);

            $vehicle = $vehicles->get($vehicleIndex) ?? $vehicles->first();

            $lead = Lead::create(array_merge($data, ['vehicle_id' => $vehicle->id]));

            LeadStatusHistory::create([
                'lead_id' => $lead->id,
                'status'  => 'new',
                'comment' => 'Lead créé automatiquement',
            ]);

            if ($lead->current_status !== 'new') {
                LeadStatusHistory::create([
                    'lead_id' => $lead->id,
                    'status'  => $lead->current_status,
                    'comment' => match($lead->current_status) {
                        'in_progress' => 'Pris en charge par le commercial',
                        'closed'      => 'Dossier clôturé, vente conclue',
                        'cancelled'   => 'Client ne donne plus suite',
                        default       => null,
                    },
                ]);
            }
        }
    }
}
