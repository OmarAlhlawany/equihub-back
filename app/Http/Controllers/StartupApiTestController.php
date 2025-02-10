<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Startup;
use Illuminate\Support\Facades\Log;

class StartupApiTestController extends Controller
{
    /**
     * Show the test page for a specific startup.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function showTestPage($id)
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

        // Construct API payload with all attributes
        $data = [
            'id'                      => $startup->id,
            'name'                    => $startup->name,
            'email'                   => $startup->email,
            'phone_number'            => $startup->phone_number,
            'company'                 => $startup->company,
            'website'                 => $startup->website,
            'product_service_description' => $startup->product_service_description,
            'company_sector'          => optional($startup->companySector)->name,
            'operational_phase'       => optional($startup->operationalPhase)->name,
            'problem_solved'          => $startup->problem_solved,
            'funding_amount'          => optional($startup->fundingAmount)->name,
            'funding_used'            => $startup->funding_used,
            'previous_funding_source' => optional($startup->previousFundingSource)->name,
            'target_market'           => optional($startup->targetMarket)->name,
            'joint_investment'        => optional($startup->jointInvestment)->name,
            'existing_partners'       => optional($startup->existingPartners)->name,
            'monthly_revenue'         => $startup->monthly_revenue,
            'is_profitable'           => optional($startup->isProfitable)->name,
            'revenue_growth'          => $startup->revenue_growth,
            'revenue_goal'            => $startup->revenue_goal,
            'have_debts'              => optional($startup->haveDebts)->name,
            'debt_amount'             => $startup->debt_amount,
            'break_even_point'        => $startup->break_even_point,
            'financial_goal'          => $startup->financial_goal,
            'has_exit_strategy'       => optional($startup->hasExitStrategy)->name,
            'exit_strategy_details'   => $startup->exit_strategy_details,
        ];

        return view('startups.api_test', compact('startup', 'data'));
    }

    /**
     * Send startup data to an AI endpoint.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendStartupData(Request $request, $id)
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

        // Construct API payload with all attributes
        $data = [
            'id'                      => $startup->id,
            'name'                    => $startup->name,
            'email'                   => $startup->email,
            'phone_number'            => $startup->phone_number,
            'company'                 => $startup->company,
            'website'                 => $startup->website,
            'product_service_description' => $startup->product_service_description,
            'company_sector'          => optional($startup->companySector)->name,
            'operational_phase'       => optional($startup->operationalPhase)->name,
            'problem_solved'          => $startup->problem_solved,
            'funding_amount'          => optional($startup->fundingAmount)->name,
            'funding_used'            => $startup->funding_used,
            'previous_funding_source' => optional($startup->previousFundingSource)->name,
            'target_market'           => optional($startup->targetMarket)->name,
            'joint_investment'        => optional($startup->jointInvestment)->name,
            'existing_partners'       => optional($startup->existingPartners)->name,
            'monthly_revenue'         => $startup->monthly_revenue,
            'is_profitable'           => optional($startup->isProfitable)->name,
            'revenue_growth'          => $startup->revenue_growth,
            'revenue_goal'            => $startup->revenue_goal,
            'have_debts'              => optional($startup->haveDebts)->name,
            'debt_amount'             => $startup->debt_amount,
            'break_even_point'        => $startup->break_even_point,
            'financial_goal'          => $startup->financial_goal,
            'has_exit_strategy'       => optional($startup->hasExitStrategy)->name,
            'exit_strategy_details'   => $startup->exit_strategy_details,
        ];

        // API Endpoint (Replace with actual URL)
        $apiUrl = 'cyme058z1wg0000y7jyggxk8ynayyyyyb.oast.pro'; // Change this to the correct API URL

        $client = new Client();
        $headers = [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer YOUR_API_KEY' // Add your actual API key if required
        ];

        try {
            // Log the request payload
            Log::info('Sending startup data to AI:', ['data' => $data]);

            // Send data to AI model
            $response = $client->post($apiUrl, [
                'json'    => $data,
                'headers' => $headers
            ]);

            // Decode response
            $body = json_decode($response->getBody(), true);

            // Log response for debugging
            Log::info('AI Response:', ['response' => $body]);

            return back()->with('success', 'Startup data sent successfully!');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('GuzzleHttp RequestException:', ['message' => $e->getMessage()]);
            return back()->with('error', 'API request failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('General Exception:', ['message' => $e->getMessage()]);
            return back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
