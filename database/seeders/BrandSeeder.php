<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Mercedes-Benz', 'BMW', 'Audi', 'Volkswagen', 'Toyota',
            'Honda', 'Ford', 'Renault', 'Peugeot', 'Hyundai',
            'Kia', 'Nissan', 'Volvo', 'Porsche', 'Land Rover',
        ];

        foreach ($brands as $name) {
            Brand::firstOrCreate(['name' => $name]);
        }
    }
}
