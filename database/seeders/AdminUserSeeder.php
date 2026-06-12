<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    // Crée le compte administrateur par défaut
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@barqawi.ch'],
            [
                'name'      => 'Administrateur BARQAWI',
                'password'  => Hash::make('Admin@2024!'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        // Compte commercial de démonstration
        User::firstOrCreate(
            ['email' => 'commercial@barqawi.ch'],
            [
                'name'      => 'Commercial BARQAWI',
                'password'  => Hash::make('Commercial@2024!'),
                'role'      => 'commercial',
                'is_active' => true,
            ]
        );
    }
}
