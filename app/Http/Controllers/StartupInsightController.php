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

            // Calculate estimated total funding (same logic as investor insights)
            $estimatedFunding = 0;
            $estimates = [
                '$ 100K to $ 500K' => 300000,
                '$ 500K to $ 1M' => 750000,
                '$ 1M to $ 5M' => 3000000,
                '$ 5M+' => 6000000
            ];
    
            foreach ($estimates as $range => $average) {
                $count = $fundingCounts[$range] ?? 0;
                $estimatedFunding += $count * $average;
            }
    
            // Format the estimated funding
            if ($estimatedFunding >= 1000000) {
                $estimatedFundingText = round($estimatedFunding / 1000000, 1) . 'M';
            } elseif ($estimatedFunding >= 1000) {
                $estimatedFundingText = round($estimatedFunding / 1000, 1) . 'K';
            } else {
                $estimatedFundingText = $estimatedFunding;
            }
            $estimatedFundingFormatted = '$' . number_format($estimatedFunding, 2, ',', '.');
    
            return view('insights_startup.index', compact(
                'startupCount',
                'fundingCounts',
                'startupPhaseCounts',
                'targetMarketCounts',
                'sectorCounts',
                'estimatedFundingFormatted',
                'estimatedFundingText'
            ));
        }
    }
        
