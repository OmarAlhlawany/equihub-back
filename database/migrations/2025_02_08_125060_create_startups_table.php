<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('startups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('company');
            $table->string('website');
            $table->text('product_service_description');

            // Foreign keys replacing enums
            $table->foreignId('company_sector_id')->constrained('company_sectors')->onDelete('cascade');
            $table->foreignId('operational_phase_id')->constrained('operational_phases')->onDelete('cascade');
            $table->foreignId('funding_amount_id')->constrained('funding_amounts')->onDelete('cascade');
            $table->foreignId('previous_funding_source_id')->constrained('funding_sources')->onDelete('cascade');
            $table->foreignId('target_market_id')->constrained('target_markets')->onDelete('cascade');

            // Boolean fields replacing Yes/No enums
            $table->foreignId('joint_investment')->constrained('yes_no_options')->onDelete('cascade');
            $table->foreignId('existing_partners')->constrained('yes_no_options')->onDelete('cascade');
            $table->foreignId('is_profitable')->constrained('yes_no_options')->onDelete('cascade');
            $table->foreignId('have_debts')->constrained('yes_no_options')->onDelete('cascade');
            $table->foreignId('has_exit_strategy')->constrained('yes_no_options')->onDelete('cascade');

            // Financial fields
            $table->decimal('monthly_revenue', 12, 2)->nullable();
            $table->decimal('revenue_growth', 5, 2)->nullable();
            $table->decimal('revenue_goal', 12, 2);
            $table->decimal('debt_amount', 12, 2)->nullable();

            // Other text fields
            $table->text('problem_solved');
            $table->text('funding_used');
            $table->string('break_even_point');
            $table->text('financial_goal');
            $table->text('exit_strategy_details')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('startups');
    }
};
