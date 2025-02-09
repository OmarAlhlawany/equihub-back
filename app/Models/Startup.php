<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Startup extends Model {
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone_number', 'company', 'website', 
        'product_service_description', 'company_sector_id', 'operational_phase_id', 
        'problem_solved', 'funding_amount_id', 'funding_used', 'previous_funding_source_id', 
        'target_market_id', 'joint_investment', 'existing_partners', 'monthly_revenue', 
        'is_profitable', 'revenue_growth', 'revenue_goal', 'have_debts', 'debt_amount', 
        'break_even_point', 'financial_goal', 'has_exit_strategy', 'exit_strategy_details'
    ];

    // Relationships
    public function companySector() {
        return $this->belongsTo(CompanySector::class);
    }

    public function operationalPhase() {
        return $this->belongsTo(OperationalPhase::class);
    }

    public function fundingAmount() {
        return $this->belongsTo(FundingAmount::class);
    }

    public function previousFundingSource() {
        return $this->belongsTo(FundingSource::class);
    }

    public function targetMarket() {
        return $this->belongsTo(TargetMarket::class);
    }

    public function jointInvestment() {
        return $this->belongsTo(YesNoOption::class, 'joint_investment');
    }

    public function existingPartners() {
        return $this->belongsTo(YesNoOption::class, 'existing_partners');
    }

    public function isProfitable() {
        return $this->belongsTo(YesNoOption::class, 'is_profitable');
    }

    public function haveDebts() {
        return $this->belongsTo(YesNoOption::class, 'have_debts');
    }

    public function hasExitStrategy() {
        return $this->belongsTo(YesNoOption::class, 'has_exit_strategy');
    }
}
