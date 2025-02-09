<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Startup;

class StartupSeeder extends Seeder {
    public function run(): void {
        Startup::factory(5947)->create();
    }
}
