<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE `lead_status_history`
            MODIFY COLUMN `status`
            ENUM('new', 'in_progress', 'closed', 'cancelled') NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE `lead_status_history`
            MODIFY COLUMN `status`
            ENUM('new', 'contacted', 'qualified', 'converted', 'lost') NOT NULL
        ");
    }
};
