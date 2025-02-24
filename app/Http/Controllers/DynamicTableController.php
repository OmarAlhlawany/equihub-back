<?php

namespace App\Http\Controllers;

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

class DynamicTableController extends Controller
{
    public function index()
    {
        return view('dynamic_tables.index', [
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
        ]);
    }

    public function store(Request $request)
{
    // Map table names to actual model class names
    $modelMap = [
        'CompanySector' => CompanySector::class,
        'OperationalPhase' => OperationalPhase::class,
        'FundingAmount' => FundingAmount::class,
        'FundingSource' => FundingSource::class,
        'TargetMarket' => TargetMarket::class,
        'InvestmentType' => InvestmentType::class,
        'FavouriteInvestmentStage' => FavouriteInvestmentStage::class,
        'FavouriteSector' => FavouriteSector::class,
        'BudgetRange' => BudgetRange::class,
        'GeographicalScope' => GeographicalScope::class,
        'InvestmentPrivacyOption' => InvestmentPrivacyOption::class,
    ];

    // Ensure the table exists in the mapping
    if (!isset($modelMap[$request->table])) {
        return redirect()->back()->with('error', 'Invalid table name: ' . $request->table);
    }

    // Create and save a new entry
    $model = new $modelMap[$request->table]();
    $model->name = $request->name;
    $model->save();

    return redirect()->back()->with('success', 'Added successfully');
}


public function destroy($table, $id)
{
    $modelMap = [
        'company_sectors' => CompanySector::class,
        'operational_phases' => OperationalPhase::class,
        'funding_amounts' => FundingAmount::class,
        'funding_sources' => FundingSource::class,
        'target_markets' => TargetMarket::class,
        'investment_types' => InvestmentType::class,
        'favourite_investment_stages' => FavouriteInvestmentStage::class,
        'favourite_sectors' => FavouriteSector::class,
        'budget_ranges' => BudgetRange::class,
        'geographical_scopes' => GeographicalScope::class,
        'investment_privacy_options' => InvestmentPrivacyOption::class,
    ];

    if (!isset($modelMap[$table])) {
        return response()->json(['error' => 'Invalid table name'], 400);
    }

    $modelClass = $modelMap[$table];
    $record = $modelClass::find($id);

    if (!$record) {
        return response()->json(['error' => 'Record not found'], 404);
    }

    $record->delete();

    return response()->json(['success' => 'Deleted successfully']);
}

    
}
