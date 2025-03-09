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
            'startup_data' => [
                [
                    'type' => 'startup',
                    'id' => $startup->id,
                    'name' => $startup->name,
                    'email' => $startup->email,
                    'phone_number' => $startup->phone_number,
                    'company' => $startup->company,
                    'company_sector_id' => (string)$startup->company_sector_id,
                    'sector' => $this->getSectorName($startup->company_sector_id),
                    'operational_phase' => $this->getOperationalPhaseName($startup->operational_phase_id),
                    'operational_phase_id' => (string)$startup->operational_phase_id,
                    'funding_amount' => $this->getFundingAmountName($startup->funding_amount_id),
                    'funding_amount_id' => (string)$startup->funding_amount_id,
                    'funding_used' => $startup->funding_used,
                    'previous_funding_source_id' => (string)$startup->previous_funding_source_id,
                    'target_market' => $this->getTargetMarketName($startup->target_market_id),
                    'target_market_id' => (string)$startup->target_market_id,
                    'revenue_growth' => $startup->revenue_growth,
                    'is_profitable' => $startup->is_profitable ? 'yes' : 'no',
                    'monthly_revenue' => $startup->monthly_revenue,
                    'product_service_description' => $startup->product_service_description,
                    'problem_solved' => $startup->problem_solved,
                    'company_valuation' => $startup->company_valuation,
                    'annual_revenue' => $startup->annual_revenue,
                    'website' => $startup->website,
                    'joint_investment' => (string)$startup->joint_investment,
                    'existing_partners' => (string)$startup->existing_partners,
                    'revenue_goal' => $startup->revenue_goal,
                    'have_debts' => $startup->have_debts ? 'yes' : 'no',
                    'debt_amount' => $startup->debt_amount,
                    'break_even_point' => $startup->break_even_point,
                    'financial_goal' => $startup->financial_goal,
                    'has_exit_strategy' => (string)$startup->has_exit_strategy // إضافة حقل has_exit_strategy
                ]
            ]
        ];

        // API Client for AI request
        $client = new Client();
        $url = 'http://85.31.236.242:5000/api/v1/nlp/pipeline/startup1o'; // Replace with actual AI endpoint
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
