<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use App\Models\CompanySector;
use App\Models\OperationalPhase;
use App\Models\FundingAmount;
use App\Models\FundingSource;
use App\Models\TargetMarket;
use App\Models\YesNoOption;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;


class StartupController extends Controller
{
    // Show startups with pagination and search functionality
    public function index(Request $request)
{
    $searchField = $request->input('search_field');
    $searchValue = $request->input('search_value');

    $query = Startup::with([
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
    ]);

    // Apply search filter if both field and value exist
    if ($searchField && $searchValue) {
        $query->where($searchField, 'LIKE', "%{$searchValue}%");
    }

    // Apply sorting if present
    if ($request->has('sort')) {
        $direction = $request->input('direction', 'asc');
        $query->orderBy($request->input('sort'), $direction);
    }

    $startups = $query->paginate(10);

    return view('startups.index', compact('startups'));
}


    // Show the form to create a new startup
    public function create()
    {
        return view('startups.create', [
            'companySectors' => CompanySector::all(),
            'operationalPhases' => OperationalPhase::all(),
            'fundingAmounts' => FundingAmount::all(),
            'fundingSources' => FundingSource::all(),
            'targetMarkets' => TargetMarket::all(),
            'yesNoOptions' => YesNoOption::all(),
        ]);
    }

    // Store a new startup
    public function store(Request $request)
    {

        Log::info('Store Startup:', $request->all());

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
            'financial_goal' => 'required|min:10',
            'has_exit_strategy' => 'required|exists:yes_no_options,id',
            'exit_strategy_details' => 'nullable|string',
        ]);

        Log::info('Validated Data:', $validated);

        Startup::create($validated);

        Log::info('Startup Created Successfully', ['name' => $validated['name']]);

        return redirect()->route('startups')->with('success', 'Startup added successfully!');
    }

    // Show startup data for editing
    public function edit(Startup $startup)
    {
        return view('startups.edit', [
            'startup' => $startup,
            'companySectors' => CompanySector::all(),
            'operationalPhases' => OperationalPhase::all(),
            'fundingAmounts' => FundingAmount::all(),
            'fundingSources' => FundingSource::all(),
            'targetMarkets' => TargetMarket::all(),
            'yesNoOptions' => YesNoOption::all(),
        ]);
    }

    // Update startup data
    public function update(Request $request, $id)
    {
        Log::info('Update Startup Request:', $request->all());

        $validated = $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:startups,email,' . $id,
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
            'financial_goal' => 'required|min:10',
            'has_exit_strategy' => 'required|exists:yes_no_options,id',
            'exit_strategy_details' => 'nullable|string',
        ]);

        Log::info('Validated Update Data:', $validated);

        $startup = Startup::findOrFail($id);
        $startup->update($validated);

        Log::info('Startup Updated Successfully', ['id' => $id, 'name' => $validated['name']]);

        return redirect()->route('startups')->with('success', 'Startup updated successfully!');
    }

    // Show the startup details
    public function show($id)
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
        ])->findOrFail($id);

        return view('startups.show', compact('startup'));
    }

    // Delete startup
    public function destroy($id)
    {
        Startup::destroy($id);
        return redirect()->route('startups')->with('success', 'Startup deleted successfully!');
    }
}