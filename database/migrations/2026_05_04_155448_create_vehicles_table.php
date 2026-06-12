<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->string('version')->nullable();
            $table->enum('vehicle_type', [
             'cabriolet_roadster',
             'suv_pickup',
             'citadine',
             'break',
             'berline',
             'monospace_minibus',
             'sport_coupe',
             'autre'
            ]);
            $table->enum('condition', ['neuf', 'occasion']);
            $table->enum('seller_type', ['concessionnaire', 'particulier', 'societe']);
            $table->integer('year');
            $table->integer('mileage');
            $table->decimal('price', 10, 2);
            $table->string('price_type')->nullable();
            $table->integer('seats')->nullable();           // Nombre de sièges
            $table->integer('doors')->nullable();           // Nombre de portes
            $table->enum('sliding_door', [
                      'aucune',
                      'droite',
                      'gauche',
                      'deux_cotes'
            ])->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            // ─── Données techniques ────────────────────────────
            $table->enum('fuel_type', [
                         'essence',
                         'diesel',
                         'electrique',
                         'bioethanol',
                         'hybride_essence',
                         'hybride_plug_in',
                         'gaz_naturel',
                         'hybride_rechargeable',
                         'gpl',
                         'autre'
            ]);
            $table->integer('power_hp')->nullable();        // Puissance en Ch
            $table->integer('power_kw')->nullable();        // Puissance en kW
            $table->integer('cylinder')->nullable();        // Cylindrée en ccm
            $table->integer('towing_capacity')->nullable(); // Capacité de remorquage
            $table->integer('weight')->nullable();          // Poids en kg
            $table->enum('drive', [
                         '4x4',
                         'traction_avant',
                         'propulsion'
            ])->nullable();
            $table->enum('transmission', [
                          'automatique',
                          'semi_automatique',
                          'manuelle'
            ])->nullable();
            $table->decimal('fuel_consumption', 5, 2)->nullable();
            $table->string('emission_standard')->nullable(); // Norme anti-pollution
            $table->boolean('dpf')->default(false);          // Filtre à particules
            // ─── Extérieur ─────────────────────────────────────
            $table->string('exterior_color')->nullable();
            $table->enum('tow_bar', [
                         'aucune',
                         'fixe',
                         'detachable',
                         'pivotant'
            ])->nullable();
            $table->enum('parking_radar', [
                         'aucun',
                         'arriere',
                         'avant',
                         'camera_360'
            ])->nullable();
            // ─── Intérieur ─────────────────────────────────────
            $table->string('interior_color')->nullable();
            $table->string('interior_material')->nullable();
            $table->enum('air_conditioning', [
                         'aucune',
                         'climatisation',
                         'climatisation_automatique'
            ])->nullable();
            // ─── État / Historique ──────────────────────────────
            $table->boolean('service_book')->default(false);     // Carnet d'entretien
            $table->boolean('safety_compliant')->default(false); // Normes sécurité
            $table->boolean('warranty')->default(false);         // Garantie
            $table->boolean('full_service')->default(false);     // Révision complète
            $table->boolean('non_smoker')->default(false);       // Véhicule non-fumeur
            $table->integer('previous_owners')->nullable();      // Propriétaires précédents
            $table->integer('ct_valid_days')->nullable();        // CT valide dans x jours
            // ─── Équipements (JSON) ─────────────────────────────
            $table->json('exterior_extras')->nullable();  // ABS, GPS, toit ouvrant...
            $table->json('interior_extras')->nullable();  // Bluetooth, USB, écran...
            // ─── Détails de l'offre ─────────────────────────────
            $table->boolean('has_photos')->default(false);
            $table->boolean('has_video')->default(false);
            $table->boolean('export_available')->default(false);
            $table->boolean('is_demonstration')->default(false);
            $table->boolean('is_collaborator')->default(false);
            $table->boolean('is_collection')->default(false);
            $table->boolean('vat_included')->default(false);
            $table->text('description')->nullable();
            // ─── Statut ────────────────────────────────────────
            $table->enum('status', ['actif', 'inactif', 'vendu'])->default('actif');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
