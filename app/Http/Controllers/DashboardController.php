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

        return view('dashboard', compact(
            'investorCount', 
            'startupCount', 
            'investmentCounts', 
            'sortedBudgetCounts', 
            'recentInvestors', 
            'recentStartups'
        ));
    }
}
