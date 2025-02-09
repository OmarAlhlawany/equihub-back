<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Investor;
use App\Models\InvestmentType;
use App\Models\FavouriteInvestmentStage;
use App\Models\BudgetRange;
use App\Models\GeographicalScope;
use App\Models\YesNoOption;
use App\Models\InvestmentPrivacyOption;
use App\Models\FavouriteSector;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InvestorController extends Controller
{
    /**
     * Store a new investor.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:investors,email',
            'phone_number' => 'required|string|max:20',
            'company' => 'required|string|max:255',
            'investment_type_id' => 'required|exists:investment_types,id',
            'favourite_investment_stage_id' => 'required|exists:favourite_investment_stages,id',
            'budget_range_id' => 'required|exists:budget_ranges,id',
            'geographical_scope_id' => 'required|exists:geographical_scopes,id',
            'co_invest_id' => 'required|exists:yes_no_options,id',
            'investment_privacy_option_id' => 'required|exists:investment_privacy_options,id',
            'favourite_sectors' => 'required|array|min:1',
            'favourite_sectors.*' => 'exists:favourite_sectors,id',
            'additional_notes' => 'nullable|string',
        ]);

        // Create the investor record
        $investor = Investor::create($validated);

        // Sync favourite sectors
        if (!empty($request->favourite_sectors)) {
            $investor->favouriteSectors()->sync($request->favourite_sectors);
        }

        return response()->json([
            'message' => 'Investor registered successfully',
            'investor' => $investor
        ], 201);
    }

    /**
     * Get investor by ID with related data.
     */
    public function show($id): JsonResponse
    {
        $investor = Investor::with([
            'investmentType',
            'favouriteInvestmentStage',
            'budgetRange',
            'geographicalScope',
            'coInvest',
            'investmentPrivacyOption',
            'favouriteSectors',
        ])->find($id);

        if (!$investor) {
            return response()->json(['message' => 'Investor not found'], 404);
        }

        return response()->json($investor);
    }
}
