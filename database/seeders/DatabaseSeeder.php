<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\InvestorSeeder;
use Database\Seeders\StartupSeeder;
use Database\Seeders\YesNoOptionSeeder;
use Database\Seeders\TargetMarketSeeder;
use Database\Seeders\FavouriteSectorSeeder;
use Database\Seeders\InvestmentPrivacyOptionSeeder;
use Database\Seeders\OperationalPhaseSeeder;
use Database\Seeders\FundingAmountSeeder;
use Database\Seeders\InvestmentTypeSeeder;
use Database\Seeders\FavouriteInvestmentStageSeeder;
use Database\Seeders\FundingSourceSeeder;
use Database\Seeders\BudgetRangeSeeder;
use Database\Seeders\GeographicalScopeSeeder;
use Database\Seeders\CompanySectorSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BudgetRangeSeeder::class);
        $this->call(CompanySectorSeeder::class);
        $this->call(FavouriteInvestmentStageSeeder::class);
        $this->call(FavouriteSectorSeeder::class);
        $this->call(FundingAmountSeeder::class);
        $this->call(FundingSourceSeeder::class);
        $this->call(GeographicalScopeSeeder::class);
        $this->call(InvestmentPrivacyOptionSeeder::class);
        $this->call(InvestmentTypeSeeder::class);
        $this->call(OperationalPhaseSeeder::class);
        $this->call(TargetMarketSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(YesNoOptionSeeder::class);
        $this->call(InvestorSeeder::class);
        $this->call(StartupSeeder::class);

    }
}