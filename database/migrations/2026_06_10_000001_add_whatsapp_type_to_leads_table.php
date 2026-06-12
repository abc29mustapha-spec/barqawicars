<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE `leads`
            MODIFY COLUMN `type`
            ENUM('contact','quote','test_drive','export','whatsapp') NOT NULL
        ");
    }

    public function down(): void
    {
        // Remove any whatsapp leads before reverting the enum
        DB::table('leads')->where('type', 'whatsapp')->delete();

        DB::statement("
            ALTER TABLE `leads`
            MODIFY COLUMN `type`
            ENUM('contact','quote','test_drive','export') NOT NULL
        ");
    }
};
