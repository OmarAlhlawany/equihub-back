<?php

namespace Database\Factories;

use App\Models\{
    Investor,
    InvestmentType,
    FavouriteInvestmentStage,
    BudgetRange,
    GeographicalScope,
    YesNoOption,
    InvestmentPrivacyOption,
    FavouriteSector
};
use Illuminate\Database\Eloquent\Factories\Factory;

class InvestorFactory extends Factory {
    protected $model = Investor::class;

    public function definition(): array {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->numerify('+971#########'),
            'company' => $this->faker->company(),
            'investment_type_id' => InvestmentType::inRandomOrder()->first()->id ?? InvestmentType::factory(),
            'favourite_investment_stage_id' => FavouriteInvestmentStage::inRandomOrder()->first()->id ?? FavouriteInvestmentStage::factory(),
            'budget_range_id' => BudgetRange::inRandomOrder()->first()->id ?? BudgetRange::factory(),
            'geographical_scope_id' => GeographicalScope::inRandomOrder()->first()->id ?? GeographicalScope::factory(),
            'co_invest_id' => YesNoOption::inRandomOrder()->first()->id ?? YesNoOption::factory(),
            'investment_privacy_option_id' => InvestmentPrivacyOption::inRandomOrder()->first()->id ?? InvestmentPrivacyOption::factory(),
            'additional_notes' => $this->faker->optional()->sentence(),
        ];
    }

    public function configure() {
        return $this->afterCreating(function (Investor $investor) {
            // Assign random favourite sectors (1 to 5 sectors)
            $sectors = FavouriteSector::inRandomOrder()->limit(rand(1, 5))->pluck('id');
            $investor->favouriteSectors()->sync($sectors);
        });
    }
}
