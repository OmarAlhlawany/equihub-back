<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'company',
        'investment_type_id',
        'favourite_investment_stage_id',
        'budget_range_id',
        'other_budget',
        'geographical_scope_id',
        'co_invest_id',
        'investment_privacy_option_id',
        'additional_notes'
    ];

    // Define relationships
    public function investmentType()
    {
        return $this->belongsTo(InvestmentType::class, 'investment_type_id');
    }

    public function favouriteInvestmentStage()
    {
        return $this->belongsTo(FavouriteInvestmentStage::class, 'favourite_investment_stage_id');
    }

    public function budgetRange()
    {
        return $this->belongsTo(BudgetRange::class, 'budget_range_id');
    }

    public function geographicalScope()
    {
        return $this->belongsTo(GeographicalScope::class, 'geographical_scope_id');
    }

    public function coInvest()
    {
        return $this->belongsTo(YesNoOption::class, 'co_invest_id');
    }

    public function investmentPrivacyOption()
    {
        return $this->belongsTo(InvestmentPrivacyOption::class, 'investment_privacy_option_id');
    }

    public function favouriteSectors()
    {
        return $this->belongsToMany(FavouriteSector::class, 'investor_favourite_sector');
    }

    public function aiResponses()
    {
        return $this->hasMany(AiResponse::class);
    }
}
