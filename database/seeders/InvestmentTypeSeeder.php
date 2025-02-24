<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvestmentType;

class InvestmentTypeSeeder extends Seeder {
    public function run(): void {
        $types = [
            'Angel Investment',
            'Investment Funding'
        ];

        foreach ($types as $type) {
            InvestmentType::create(['name' => $type]);
        }
    }
}
