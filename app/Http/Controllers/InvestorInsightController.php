<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Startup;
use App\Models\InvestmentType;
use App\Models\BudgetRange;
use App\Models\GeographicalScope;
use App\Models\OperationalPhase;
use App\Models\FavouriteSector;
use Illuminate\Http\Request;

class InvestorInsightController extends Controller
{
    public function index()
    {
        // Total Counts
        $investorCount = Investor::count();

        // Investors by Investment Type
        $investmentCounts = InvestmentType::withCount('investors')->pluck('investors_count', 'name')->toArray();

        $budgetOrder = [
            '$100K to $500K',
            '$500K to $1M',
            '$1M to $5M',
            '$5M+',
            'Other'
        ];
        
        $budgetCounts = BudgetRange::withCount('investors')->pluck('investors_count', 'name')->toArray();
        
        $sortedBudgetCounts = [];
        foreach ($budgetOrder as $budget) {
            $sortedBudgetCounts[$budget] = $budgetCounts[$budget] ?? 0;
        }
        
        
        // Investors by Geographical Scope
        $geographicalCounts = GeographicalScope::withCount('investors')->pluck('investors_count', 'name')->toArray();

        

        // Investors by Favourite Sectors
        $sectorCounts = FavouriteSector::withCount('investors')->pluck('investors_count', 'name')->toArray();

        // Split sector data into two parts for visualization
        $sectorKeys = array_keys($sectorCounts);
        $sectorValues = array_values($sectorCounts);
        $half = ceil(count($sectorKeys) / 2);
        $sector1 = array_slice($sectorKeys, 0, $half);
        $count1 = array_slice($sectorValues, 0, $half);
        $sector2 = array_slice($sectorKeys, $half);
        $count2 = array_slice($sectorValues, $half);


        $estimatedBudget = 0;

$estimates = [
    '$100K to $500K' => 300000, // متوسط تقريبي
    '$500K to $1M' => 750000,
    '$1M to $5M' => 3000000,
    '$5M+' => 6000000
];

foreach ($estimates as $range => $average) {
    $count = $sortedBudgetCounts[$range] ?? 0;
    $estimatedBudget += $count * $average;
}

if ($estimatedBudget >= 1000000) {
    $estimatedBudgetText = round($estimatedBudget / 1000000, 1) . 'M';
} elseif ($estimatedBudget >= 1000) {
    $estimatedBudgetText = round($estimatedBudget / 1000, 1) . 'K';
} else {
    $estimatedBudgetText = $estimatedBudget;
}
$estimatedBudgetFormatted = '$' . number_format($estimatedBudget, 2, ',', '.');

        return view('insights_investor.index', compact(
            'investorCount',
            'investmentCounts',
            'budgetCounts',
            'sortedBudgetCounts',
            'geographicalCounts',
            'sector1',
            'count1',
            'sector2',
            'count2',
            'estimatedBudget',

            'estimatedBudgetFormatted'
        ));
    }
}
