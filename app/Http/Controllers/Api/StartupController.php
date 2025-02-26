<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Startup;
use App\Models\AiResponse; // Assuming the AI response model exists
use App\Models\CompanySector;
use App\Models\OperationalPhase;
use App\Models\FundingAmount;
use App\Models\FundingSource;
use App\Models\TargetMarket;
use App\Models\YesNoOption;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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

        // Create the startup record
        $startup = Startup::create($validated);

        // Send the startup data to AI without returning any data to the user
        $this->sendToAI($startup);

        // Return a simple success message without detailed data
        return response()->json([
            'message' => 'Startup registered and data sent to AI successfully.'
        ], 201);
    }

    /**
     * Send startup data to the AI system.
     */
    private function sendToAI($startup)
    {
        // Prepare the data to send to the AI
        $data = [
            'json_data' => [
                'type' => 'startup',
                'id' => $startup->id,
                'name' => $startup->name,
                'email' => $startup->email,
                'phone' => $startup->phone_number,
                'company' => $startup->company,
                'website' => $startup->website,
                'product_service_description' => $startup->product_service_description,
                'company_sector' => optional($startup->companySector)->name,
                'operational_phase' => optional($startup->operationalPhase)->name,
                'problem_solved' => $startup->problem_solved,
                'funding_amount' => optional($startup->fundingAmount)->name,
                'funding_used' => $startup->funding_used,
                'previous_funding_source' => optional($startup->previousFundingSource)->name,
                'target_market' => optional($startup->targetMarket)->name,
                'joint_investment' => optional($startup->jointInvestment)->name,
                'existing_partners' => optional($startup->existingPartners)->name,
                'monthly_revenue' => $startup->monthly_revenue,
                'is_profitable' => optional($startup->isProfitable)->name,
                'revenue_growth' => $startup->revenue_growth,
                'revenue_goal' => $startup->revenue_goal,
                'have_debts' => optional($startup->haveDebts)->name,
                'debt_amount' => $startup->debt_amount,
                'break_even_point' => $startup->break_even_point,
                'financial_goal' => $startup->financial_goal,
                'has_exit_strategy' => optional($startup->hasExitStrategy)->name,
                'exit_strategy_details' => $startup->exit_strategy_details,
            ],
            'limit' => 5
        ];

        // API Client for AI request
        $client = new Client();
        $url = 'http://85.31.236.242:5000/api/v1/nlp/index/answer/startups'; // Replace with actual AI endpoint
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer YOUR_API_KEY' // Replace with actual API key
        ];

        try {
            // Send data to AI
            $response = $client->post($url, [
                'json' => $data,
                'headers' => $headers
            ]);

            // Decode AI response (optional: you can log the response if needed)
            $body = json_decode($response->getBody(), true);

            // Store the AI response in the database
            AiResponse::create([
                'startup_id' => $startup->id,
                'response_data' => json_encode($body)
            ]);

            // Log the AI response for debugging
            Log::info('AI Response:', ['response' => $body]);
        } catch (\Exception $e) {
            // Log any errors
            Log::error('Error sending data to AI:', ['message' => $e->getMessage()]);
        }
    }
}