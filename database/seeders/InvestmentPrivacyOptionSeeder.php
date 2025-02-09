<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvestmentPrivacyOption;

class InvestmentPrivacyOptionSeeder extends Seeder {
    public function run(): void {
        $options = ['Keep my investments private', 'Announce my investments'];

        foreach ($options as $option) {
            InvestmentPrivacyOption::create(['name' => $option]);
        }
    }
}
