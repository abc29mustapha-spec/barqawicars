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
        Schema::create('lead_status_history', function (Blueprint $table) {
            $table->id();
            // Référence au lead
            $table->foreignId('lead_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Statut
            $table->enum('status', ['new', 'contacted', 'qualified', 'converted', 'lost']);

            // Commentaire
            $table->text('comment')->nullable();

            // Seulement created_at (pas updated_at)
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_status_history');
    }
};
