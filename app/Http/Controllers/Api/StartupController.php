<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Startup;
use App\Models\CompanySector;
use App\Models\OperationalPhase;
use App\Models\FundingAmount;
use App\Models\FundingSource;
use App\Models\TargetMarket;
use App\Models\YesNoOption;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StartupController extends Controller
{
    /**
     * Store a new startup.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:startups,email',
            'phone_number' => 'required|regex:/^[- +()0-9]+$/',
            'company' => 'required|min:2',
            'website' => 'required|url',
            'product_service_description' => 'required|min:10',
            'company_sector_id' => 'required|exists:company_sectors,id',
            'operational_phase_id' => 'required|exists:operational_phases,id',
            'problem_solved' => 'required|min:10',
            'funding_amount_id' => 'required|exists:funding_amounts,id',
            'funding_used' => 'required|min:10',
            'previous_funding_source_id' => 'required|exists:funding_sources,id',
            'target_market_id' => 'required|exists:target_markets,id',
            'joint_investment' => 'required|exists:yes_no_options,id',
            'existing_partners' => 'required|exists:yes_no_options,id',
            'monthly_revenue' => 'nullable|numeric|min:0',
            'is_profitable' => 'required|exists:yes_no_options,id',
            'revenue_growth' => 'nullable|numeric|min:0|max:100',
            'revenue_goal' => 'required|numeric|min:0',
            'have_debts' => 'required|exists:yes_no_options,id',
            'debt_amount' => 'nullable|numeric|min:0',
            'break_even_point' => 'required|string',
            'financial_goal' => 'required|min:20',
            'has_exit_strategy' => 'required|exists:yes_no_options,id',
            'exit_strategy_details' => 'nullable|string',
        ]);

        $startup = Startup::create($validated);

        return response()->json([
            'message' => 'Startup registered successfully',
            'startup' => $startup
        ], 201);
    }

    /**
     * Get startup by ID with related data.
     */
    public function show($id): JsonResponse
    {
        $startup = Startup::with([
            'companySector',
            'operationalPhase',
            'fundingAmount',
            'previousFundingSource',
            'targetMarket',
            'jointInvestment',
            'existingPartners',
            'isProfitable',
            'haveDebts',
            'hasExitStrategy'
        ])->find($id);

        if (!$startup) {
            return response()->json(['message' => 'Startup not found'], 404);
        }

        return response()->json($startup);
    }
}
