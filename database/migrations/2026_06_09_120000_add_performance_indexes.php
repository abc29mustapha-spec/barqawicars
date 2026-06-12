<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── vehicles ──────────────────────────────────────────────────────────
        Schema::table('vehicles', function (Blueprint $table) {
            // scopeActif() + SoftDeletes : utilisés sur TOUTES les requêtes front
            $table->index(['status', 'deleted_at'], 'idx_vehicles_status_deleted');

            // Filtres catalogue
            $table->index('vehicle_type', 'idx_vehicles_vehicle_type');
            $table->index('fuel_type',    'idx_vehicles_fuel_type');
            $table->index('condition',    'idx_vehicles_condition');

            // Tris courants du catalogue
            $table->index('price',   'idx_vehicles_price');
            $table->index('year',    'idx_vehicles_year');
            $table->index('mileage', 'idx_vehicles_mileage');
        });

        // ── vehicle_images ────────────────────────────────────────────────────
        Schema::table('vehicle_images', function (Blueprint $table) {
            // Vehicle::mainImage() → where('is_main', true) sur chaque card
            $table->index(['vehicle_id', 'is_main'], 'idx_vehicle_images_main');
        });

        // ── leads ─────────────────────────────────────────────────────────────
        Schema::table('leads', function (Blueprint $table) {
            // Dashboard admin : COUNT par current_status
            $table->index('current_status', 'idx_leads_current_status');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropIndex('idx_vehicles_status_deleted');
            $table->dropIndex('idx_vehicles_vehicle_type');
            $table->dropIndex('idx_vehicles_fuel_type');
            $table->dropIndex('idx_vehicles_condition');
            $table->dropIndex('idx_vehicles_price');
            $table->dropIndex('idx_vehicles_year');
            $table->dropIndex('idx_vehicles_mileage');
        });

        Schema::table('vehicle_images', function (Blueprint $table) {
            $table->dropIndex('idx_vehicle_images_main');
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->dropIndex('idx_leads_current_status');
        });
    }
};
