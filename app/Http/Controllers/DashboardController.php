<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investor;
use App\Models\Startup;
use App\Models\InvestmentType;
use App\Models\BudgetRange;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Counts
        $investorCount = Investor::count();
        $startupCount = Startup::count();

        // Investors by Investment Type
        $investmentCounts = InvestmentType::withCount('investors')->pluck('investors_count', 'name')->toArray();

        // Investors by Budget Range (Sorted)
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

        // Fetch recent investors & startups (Limit 5)
        $recentInvestors = Investor::first()->take(5)->get();
        $recentStartups = Startup::first()->take(5)->get();

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

        return view('dashboard', compact(
            'investorCount', 
            'startupCount', 
            'investmentCounts', 
            'sortedBudgetCounts', 
            'recentInvestors', 
            'recentStartups',
            'estimatedBudgetFormatted'
        ));
    }
}
