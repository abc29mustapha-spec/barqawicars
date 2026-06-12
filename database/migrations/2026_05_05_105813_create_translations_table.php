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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            // Type d'entité concernée
            $table->string('entity_type'); // vehicle | page | service

            // ID de l'entité traduite
            $table->unsignedBigInteger('entity_id');

            // Langue
            $table->enum('locale', ['de', 'fr', 'en', 'ar']);

            // Champ traduit
            $table->string('field'); // title | description | content

            // Contenu traduit
            $table->text('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
