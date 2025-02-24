<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FavouriteInvestmentStage;

class FavouriteInvestmentStageSeeder extends Seeder {
    public function run(): void {
        $stages = [
            'Pre-Seed',
            'Seed',
            'Pre-Series A'
        ];

        foreach ($stages as $stage) {
            FavouriteInvestmentStage::create(['name' => $stage]);
        }
    }
}
