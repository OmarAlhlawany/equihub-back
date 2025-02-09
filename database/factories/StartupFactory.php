<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{CompanySector, OperationalPhase, FundingAmount, FundingSource, TargetMarket, YesNoOption};

class StartupFactory extends Factory {
    public function definition(): array {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->numerify('+971#########'), // UAE phone format
            'company' => $this->faker->company,
            'website' => $this->faker->url,
            'product_service_description' => $this->faker->sentence(10),

            // Dynamic foreign key values
            'company_sector_id' => CompanySector::inRandomOrder()->first()->id ?? CompanySector::factory(),
            'operational_phase_id' => OperationalPhase::inRandomOrder()->first()->id ?? OperationalPhase::factory(),
            'funding_amount_id' => FundingAmount::inRandomOrder()->first()->id ?? FundingAmount::factory(),
            'previous_funding_source_id' => FundingSource::inRandomOrder()->first()->id ?? FundingSource::factory(),
            'target_market_id' => TargetMarket::inRandomOrder()->first()->id ?? TargetMarket::factory(),

            // Boolean foreign keys (Yes/No options)
            'joint_investment' => YesNoOption::inRandomOrder()->first()->id ?? YesNoOption::factory(),
            'existing_partners' => YesNoOption::inRandomOrder()->first()->id ?? YesNoOption::factory(),
            'is_profitable' => YesNoOption::inRandomOrder()->first()->id ?? YesNoOption::factory(),
            'have_debts' => YesNoOption::inRandomOrder()->first()->id ?? YesNoOption::factory(),
            'has_exit_strategy' => YesNoOption::inRandomOrder()->first()->id ?? YesNoOption::factory(),

            // Financial fields
            'monthly_revenue' => $this->faker->randomFloat(2, 1000, 1000000),
            'revenue_growth' => $this->faker->randomFloat(2, 0, 100),
            'revenue_goal' => $this->faker->randomFloat(2, 50000, 5000000),
            'debt_amount' => $this->faker->optional()->randomFloat(2, 1000, 1000000),

            // Other fields
            'problem_solved' => $this->faker->sentence(20),
            'funding_used' => $this->faker->sentence(20),
            'break_even_point' => $this->faker->sentence(5),
            'financial_goal' => $this->faker->sentence(20),
            'exit_strategy_details' => $this->faker->optional()->sentence(20),
        ];
    }
}
