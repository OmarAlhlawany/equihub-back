<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FundingAmount;

class FundingAmountSeeder extends Seeder {
    public function run(): void {
        $fundingRanges = [
            '$ 100K to $ 500K', 
            '$ 500K to $ 1M', 
            '$ 1M to $ 5M', 
            '$ 5M+', 
            'Other'
        ];

        foreach ($fundingRanges as $range) {
            FundingAmount::create(['name' => $range]);
        }
    }
}
