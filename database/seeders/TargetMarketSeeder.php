<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TargetMarket;

class TargetMarketSeeder extends Seeder {
    public function run(): void {
        $markets = [
            'Local (UAE)', 
            'Gulf', 
            'Regional'
        ];

        foreach ($markets as $market) {
            TargetMarket::create(['name' => $market]);
        }
    }
}
