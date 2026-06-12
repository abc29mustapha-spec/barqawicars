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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            // Utilisateur ayant effectué l'action
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Action effectuée
            $table->string('action'); // create | update | delete | import | login | logout

            // Type d'entité concernée
            $table->string('entity_type'); // vehicle | lead | user

            // ID de l'entité concernée
            $table->unsignedBigInteger('entity_id')->nullable();

            // Adresse IP
            $table->string('ip_address')->nullable();

            // Navigateur
            $table->string('user_agent')->nullable();

            // Date de l'action (immuable, pas de updated_at)
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
