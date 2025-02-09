<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\YesNoOption;

class YesNoOptionSeeder extends Seeder {
    public function run(): void {
        $options = ['yes', 'no'];

        foreach ($options as $option) {
            YesNoOption::create(['name' => $option]);
        }
    }
}
