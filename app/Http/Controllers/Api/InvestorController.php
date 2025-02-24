<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Investor;
use App\Models\AiResponse;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InvestorController extends Controller
{
    /**
     * Store a new investor.
     */
    public function store(Request $request): JsonResponse
    {
        // Validate the incoming request data
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

        // Send data to AI after saving the investor
        $this->sendInvestorDataToAI($investor);

        // Return a success response with the investor data
        return response()->json([
            'message' => 'Investor registered successfully',
            'investor' => $investor
        ], 201);
    }

    /**
     * Send investor data to the AI system.
     */
    private function sendInvestorDataToAI($investor)
    {
        // Prepare the data to send to the AI
        $data = [
            'json_data' => [
                'type' => 'investor',
                'id' => $investor->id,
                'name' => $investor->name,
                'email' => $investor->email,
                'phone' => $investor->phone_number,
                'company' => $investor->company,
                'investment_type' => optional($investor->investmentType)->name,
                'favourite_investment_stage' => optional($investor->favouriteInvestmentStage)->name,
                'budget_range' => optional($investor->budgetRange)->name,
                'geographical_scope' => optional($investor->geographicalScope)->name,
                'co_invest' => optional($investor->coInvest)->name,
                'investment_privacy_option' => optional($investor->investmentPrivacyOption)->name,
                'favourite_sectors' => $investor->favouriteSectors->pluck('name')->toArray(),
                'additional_notes' => $investor->additional_notes
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
            // Log the request payload for debugging
            Log::channel('custom_investor')->info('Sending investor data to AI:', ['data' => $data]);

            // Send data to AI
            $response = $client->post($url, [
                'json' => $data,
                'headers' => $headers
            ]);

            // Log the raw AI response (before decoding)
            Log::channel('custom_investor')->info('AI Raw Response:', ['response' => $response->getBody()]);

            // Decode AI response
            $body = json_decode($response->getBody(), true);

            // Store the AI response in the database
            AiResponse::create([
                'investor_id' => $investor->id,
                'response_data' => json_encode($body)
            ]);

            // Log the AI response for debugging
            Log::channel('custom_investor')->info('AI Response:', ['response' => $body]);

        } catch (\Exception $e) {
            // Log any errors
            Log::channel('custom_investor')->error('Error sending data to AI:', ['message' => $e->getMessage()]);
        }
    }

    /**
     * Get investor by ID with related data.
     */
    public function show($id): JsonResponse
    {
        // Retrieve investor with related data
        $investor = Investor::with([
            'investmentType',
            'favouriteInvestmentStage',
            'budgetRange',
            'geographicalScope',
            'coInvest',
            'investmentPrivacyOption',
            'favouriteSectors',
        ])->find($id);

        // Check if the investor exists
        if (!$investor) {
            return response()->json(['message' => 'Investor not found'], 404);
        }

        // Return the investor data as a JSON response
        return response()->json($investor);
    }
}