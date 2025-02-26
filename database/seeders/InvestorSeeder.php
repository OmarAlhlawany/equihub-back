<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Investor;

class InvestorSeeder extends Seeder
{
    public function run()
    {
        // Create 20 investors using the factory
        Investor::factory(3)->create();
    }
}