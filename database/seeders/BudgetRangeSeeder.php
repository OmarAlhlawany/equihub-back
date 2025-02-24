<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BudgetRange;

class BudgetRangeSeeder extends Seeder {
    public function run(): void {
        $ranges = [
            '$100K to $500K',
            '$500K to $1M',
            '$1M to $5M',
            '$5M+',
            'Other'
        ];

        foreach ($ranges as $range) {
            BudgetRange::create(['name' => $range]);
        }
    }
}
