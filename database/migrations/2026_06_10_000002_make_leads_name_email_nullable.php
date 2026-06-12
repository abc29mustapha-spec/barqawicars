<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `leads` MODIFY COLUMN `name`  VARCHAR(255) NULL");
        DB::statement("ALTER TABLE `leads` MODIFY COLUMN `email` VARCHAR(255) NULL");
    }

    public function down(): void
    {
        DB::table('leads')->whereNull('name')->update(['name'  => '[Supprimé]']);
        DB::table('leads')->whereNull('email')->update(['email' => 'supprime@barqawi.invalid']);
        DB::statement("ALTER TABLE `leads` MODIFY COLUMN `name`  VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE `leads` MODIFY COLUMN `email` VARCHAR(255) NOT NULL");
    }
};
