<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('investors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('company');

            // Foreign keys for dynamic tables
            $table->foreignId('investment_type_id')->constrained('investment_types')->onDelete('cascade');
            $table->foreignId('favourite_investment_stage_id')->constrained('favourite_investment_stages')->onDelete('cascade');
            $table->foreignId('budget_range_id')->constrained('budget_ranges')->onDelete('cascade');
            $table->decimal('other_budget', 12, 2)->nullable();
            $table->foreignId('geographical_scope_id')->constrained('geographical_scopes')->onDelete('cascade');
            $table->foreignId('co_invest_id')->constrained('yes_no_options')->onDelete('cascade');
            $table->foreignId('investment_privacy_option_id')->constrained('investment_privacy_options')->onDelete('cascade');

            $table->text('additional_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investors');
    }
};
