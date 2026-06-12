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
        Schema::create('consents', function (Blueprint $table) {
            $table->id();
            // Référence au lead
            $table->foreignId('lead_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Type de consentement
            $table->enum('consent_type', ['form', 'cookies']);

            // Adresse IP
            $table->string('ip_address');

            // Navigateur
            $table->string('user_agent');

            // Date du consentement (pas de updated_at car immuable)
            $table->timestamp('consented_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consents');
    }
};
