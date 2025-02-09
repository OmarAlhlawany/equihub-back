<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanySector;

class CompanySectorSeeder extends Seeder {
    public function run(): void {
        $sectors = [
            'Technology', 'Fintech', 'HealthTech', 'Edtech', 'Ecommerce',
            'Renewable Energy', 'Cybersecurity', 'AgriTech', 'PropTech',
            'Gaming', 'Sports & Fitness', 'Logistics & Transportation',
            'Food & Beverages', 'Sustainability', 'Artificial Intelligence', 'Other'
        ];

        foreach ($sectors as $sector) {
            CompanySector::create(['name' => $sector]);
        }
    }
}
