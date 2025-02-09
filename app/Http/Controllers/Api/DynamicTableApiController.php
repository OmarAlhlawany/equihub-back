<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanySector;
use App\Models\OperationalPhase;
use App\Models\FundingAmount;
use App\Models\FundingSource;
use App\Models\TargetMarket;
use App\Models\InvestmentType;
use App\Models\FavouriteInvestmentStage;
use App\Models\FavouriteSector;
use App\Models\BudgetRange;
use App\Models\GeographicalScope;
use App\Models\InvestmentPrivacyOption;
use App\Models\YesNoOption;

class DynamicTableApiController extends Controller
{
    public function getTables()
    {
        return response()->json([
            'company_sectors' => CompanySector::all(),
            'operational_phases' => OperationalPhase::all(),
            'funding_amounts' => FundingAmount::all(),
            'funding_sources' => FundingSource::all(),
            'target_markets' => TargetMarket::all(),
            'investment_types' => InvestmentType::all(),
            'favourite_investment_stages' => FavouriteInvestmentStage::all(),
            'favourite_sectors' => FavouriteSector::all(),
            'budget_ranges' => BudgetRange::all(),
            'geographical_scopes' => GeographicalScope::all(),
            'investment_privacy_options' => InvestmentPrivacyOption::all(),
            'yes_no_options' => YesNoOption::all()
        ]);
    }
}
