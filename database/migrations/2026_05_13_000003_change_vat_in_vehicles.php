<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('vat_included');
            $table->enum('vat_status', ['recuperable', 'non_recuperable'])->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('vat_status');
            $table->boolean('vat_included')->default(false)->after('description');
        });
    }
};
