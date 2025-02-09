<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeographicalScope;

class GeographicalScopeSeeder extends Seeder {
    public function run(): void {
        $scopes = [
            'United Arab Emirates',
            'GCC',
            'Regional'
        ];

        foreach ($scopes as $scope) {
            GeographicalScope::create(['name' => $scope]);
        }
    }
}
