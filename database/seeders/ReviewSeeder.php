<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'author'       => 'Thomas L. — Strasbourg',
                'rating'       => 5,
                'body'         => 'Je voulais un M340i avec M Sport Pro, Frozen Grey et head-up display. Cette configuration n\'existait pas en France sous 52 000 €. BARQAWI l\'a trouvé à Munich à 41 000 €. Livré en 17 jours. Exactement comme décrit. Service remarquable.',
                'source'       => 'google',
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'author'       => 'Sophie M. — Bordeaux',
                'rating'       => 5,
                'body'         => 'Première fois que j\'achetais une voiture à l\'étranger, j\'avais quelques inquiétudes. BARQAWI a expliqué chaque étape et géré toute la paperasse allemande. Le COC était déjà dans le véhicule à la livraison. Aucun problème pour l\'immatriculation. Professionnel et rassurant.',
                'source'       => 'google',
                'is_published' => true,
                'published_at' => now()->subDays(45),
            ],
            [
                'author'       => 'Karim B. — Paris',
                'rating'       => 5,
                'body'         => 'L\'immatriculation ANTS a été bien plus simple que prévu — le dossier de BARQAWI était complet et correct. Carte grise obtenue en 8 jours. Au total, du premier WhatsApp à la livraison à domicile : 19 jours. Je recommande sans hésitation.',
                'source'       => 'direct',
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'author'       => 'Nordine A. — Marseille',
                'rating'       => 5,
                'body'         => 'BARQAWI a trouvé exactement la spec que je voulais en 3 jours — Break AMG-Line avec panoramique et head-up display, introuvable en France à ce prix. Livraison à Marseille en parfait état. Économie de 11 400 € sur le prix marché français. Je les recommande vivement.',
                'source'       => 'facebook',
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ],
            [
                'author'       => 'Rachid M. — Casablanca',
                'rating'       => 5,
                'body'         => 'BARQAWI a sourcé exactement le X5 dont j\'avais besoin — 7 places, xDrive40d, TÜV valide 2 ans, historique complet chez un concessionnaire BMW à Munich. Livraison à Casablanca en 5,5 semaines fret maritime inclus. Toute la paperasse douanière gérée.',
                'source'       => 'direct',
                'is_published' => true,
                'published_at' => now()->subDays(60),
            ],
            [
                'author'       => 'Marie-France D. — Lyon',
                'rating'       => 5,
                'body'         => 'Le stock français pour le 530d Touring était décevant — kilométrage élevé ou mal équipé. En Allemagne, 50+ véhicules correspondaient à mes critères. J\'ai obtenu la configuration exacte voulue, 8 200 € moins cher que le seul concessionnaire français qui proposait cela. Je recommande BARQAWI à tout le monde.',
                'source'       => 'google',
                'is_published' => true,
                'published_at' => now()->subDays(22),
            ],
        ];

        foreach ($reviews as $data) {
            Review::firstOrCreate(
                ['author' => $data['author']],
                $data
            );
        }

        $this->command->info('✅ ' . count($reviews) . ' avis clients publiés insérés.');
    }
}
