<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\InvestmentType;
use App\Models\FavouriteInvestmentStage;
use App\Models\BudgetRange;
use App\Models\GeographicalScope;
use App\Models\YesNoOption;
use App\Models\InvestmentPrivacyOption;
use App\Models\FavouriteSector;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    /**
     * Display a listing of investors with pagination and search functionality.
     */
    public function index(Request $request)
    {
        // Get search parameters
        $searchField = $request->input('search_field');
        $searchValue = $request->input('search_value');

        // Start query
        $query = Investor::query();

        // Apply search filter if both field and value exist
        if ($searchField && $searchValue) {
            $query->where($searchField, 'LIKE', "%{$searchValue}%");
        }

        // Paginate the results
        $investors = $query->paginate(10);

        return view('investors.index', compact('investors'));
    }

    /**
     * Show the form for creating a new investor.
     */
    public function create()
    {
        return view('investors.create', [
            'investmentTypes' => InvestmentType::all(),
            'investmentStages' => FavouriteInvestmentStage::all(),
            'budgetRanges' => BudgetRange::all(),
            'geographicalScopes' => GeographicalScope::all(),
            'yesNoOptions' => YesNoOption::all(),
            'investmentPrivacyOptions' => InvestmentPrivacyOption::all(),
            'favouriteSectors' => FavouriteSector::all(),
        ]);
    }

    /**
     * Store a newly created investor in the database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:investors,email',
            'phone_number' => 'required|string',
            'company' => 'required|string',
            'investment_type_id' => 'required|exists:investment_types,id',
            'favourite_investment_stage_id' => 'required|exists:favourite_investment_stages,id',
            'budget_range_id' => 'required|exists:budget_ranges,id',
            'geographical_scope_id' => 'required|exists:geographical_scopes,id',
            'co_invest_id' => 'required|exists:yes_no_options,id',
            'investment_privacy_option_id' => 'required|exists:investment_privacy_options,id',
            'favourite_sectors' => 'array',
            'favourite_sectors.*' => 'exists:favourite_sectors,id',
            'additional_notes' => 'nullable|string',
        ]);

        // Create investor
        $investor = Investor::create($data);

        // Sync favourite sectors
        if (!empty($request->favourite_sectors)) {
            $investor->favouriteSectors()->sync($request->favourite_sectors);
        }

        return redirect()->route('investors')->with('success', 'Investor added successfully!');
    }

    /**
     * Show the form for editing the specified investor.
     */
    public function edit($id)
    {
        $investor = Investor::with('favouriteSectors')->findOrFail($id);

        return view('investors.edit', [
            'investor' => $investor,
            'investmentTypes' => InvestmentType::all(),
            'investmentStages' => FavouriteInvestmentStage::all(),
            'budgetRanges' => BudgetRange::all(),
            'geographicalScopes' => GeographicalScope::all(),
            'yesNoOptions' => YesNoOption::all(),
            'investmentPrivacyOptions' => InvestmentPrivacyOption::all(),
            'favouriteSectors' => FavouriteSector::all(),
        ]);
    }

    /**
     * Update the specified investor in the database.
     */
    public function update(Request $request, Investor $investor)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:50',
            'email' => 'sometimes|required|email|unique:investors,email,' . $investor->id,
            'phone_number' => 'sometimes|required|string',
            'company' => 'sometimes|required|string',
            'investment_type_id' => 'sometimes|required|exists:investment_types,id',
            'favourite_investment_stage_id' => 'sometimes|required|exists:favourite_investment_stages,id',
            'budget_range_id' => 'sometimes|required|exists:budget_ranges,id',
            'geographical_scope_id' => 'sometimes|required|exists:geographical_scopes,id',
            'co_invest_id' => 'sometimes|required|exists:yes_no_options,id',
            'investment_privacy_option_id' => 'sometimes|required|exists:investment_privacy_options,id',
            'favourite_sectors' => 'array',
            'favourite_sectors.*' => 'exists:favourite_sectors,id',
            'additional_notes' => 'nullable|string',
        ]);

        // Update investor
        $investor->update($data);

        // Sync favourite sectors
        if (!empty($request->favourite_sectors)) {
            $investor->favouriteSectors()->sync($request->favourite_sectors);
        }

        return redirect()->route('investors')->with('success', 'Investor updated successfully!');
    }

    /**
     * Display the specified investor's details.
     */
    public function show($id)
    {
        $investor = Investor::with([
            'investmentType',
            'favouriteInvestmentStage',
            'budgetRange',
            'geographicalScope',
            'coInvest',
            'investmentPrivacyOption',
            'favouriteSectors',
        ])->findOrFail($id);

        return view('investors.show', compact('investor'));
    }

    /**
     * Remove the specified investor from the database.
     */
    public function destroy($id)
    {
        $investor = Investor::findOrFail($id);
        $investor->favouriteSectors()->detach(); // Remove relationships before deletion
        $investor->delete();

        return redirect()->route('investors')->with('success', 'Investor deleted successfully!');
    }
}
