<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OperationalPhase;

class OperationalPhaseSeeder extends Seeder {
    public function run(): void {
        $phases = ['Pre-Seed', 'Seed', 'Pre-Series A', 'Series A', 'Series B'];

        foreach ($phases as $phase) {
            OperationalPhase::create(['name' => $phase]);
        }
    }
}
