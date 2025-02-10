<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use App\Models\CompanySector;
use App\Models\OperationalPhase;
use App\Models\FundingAmount;
use App\Models\TargetMarket;
use Illuminate\Http\Request;

class StartupInsightController extends Controller
{
    public function index()
    {
        // Total Count of Startups
        $startupCount = Startup::count();

        // Startups by Funding Amount
        $fundingCounts = FundingAmount::withCount('startups')->pluck('startups_count', 'name')->toArray();

        // Startups by Operational Phase
        $startupPhaseCounts = OperationalPhase::withCount('startups')->pluck('startups_count', 'name')->toArray();

        // Startups by Target Market
        $targetMarketCounts = TargetMarket::withCount('startups')->pluck('startups_count', 'name')->toArray();

        // Startups by Company Sector
        $sectorCounts = CompanySector::withCount('startups')->pluck('startups_count', 'name')->toArray();

        return view('insights_startup.index', compact(
            'startupCount',
            'fundingCounts',
            'startupPhaseCounts',
            'targetMarketCounts',
            'sectorCounts'
        ));
    }
}
