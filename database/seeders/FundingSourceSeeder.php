<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FundingSource;

class FundingSourceSeeder extends Seeder {
    public function run(): void {
        $sources = [
            'Angel Funding', 
            'Loans', 
            'Self-financing', 
            'Investment funds', 
            'Other Sources'
        ];

        foreach ($sources as $source) {
            FundingSource::create(['name' => $source]);
        }
    }
}
