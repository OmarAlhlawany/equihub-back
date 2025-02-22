<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Investor;
use Illuminate\Support\Facades\Log;

class InvestorApiTestController extends Controller
{
    /**
     * Show the investor API test page.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function showTestPage($id)
    {
        $investor = Investor::with([
            'investmentType',
            'favouriteInvestmentStage',
            'budgetRange',
            'geographicalScope',
            'coInvest',
            'investmentPrivacyOption',
            'favouriteSectors'
        ])->findOrFail($id);

        // Prepare JSON data to display on the Blade file
        $data = [
            'type' =>'investor',
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
        ];

        return view('investors.api_test', compact('investor', 'data'));
    }

    /**
     * Send investor data to an AI endpoint.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendInvestorData(Request $request, $id)
    {
        $investor = Investor::with([
            'investmentType',
            'favouriteInvestmentStage',
            'budgetRange',
            'geographicalScope',
            'coInvest',
            'investmentPrivacyOption',
            'favouriteSectors'
        ])->findOrFail($id);

        // Construct API payload
        $data = [
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
        ];

        $client = new Client();
        $url = 'http://85.31.236.242:5000/docs#/api/v1/nlp/index/answer/startups'; // Replace with actual AI endpoint
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer YOUR_API_KEY' // Add actual API key if required
        ];

        try {

            // Log the request payload
            Log::channel('custom_investor')->info('Sending startup data to AI:', ['data' => $data]);
            // Send data to AI model
            $response = $client->post($url, [
                'json' => $data,
                'headers' => $headers
            ]);

            // Decode response
            $body = json_decode($response->getBody(), true);

            // Log response for debugging
            Log::channel('custom_investor')->info('AI Response:', ['response' => $body]);

            return back()->with('success', 'Investor data sent successfully!');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log:: channel ('custom_investor')->error('GuzzleHttp RequestException:', ['message' => $e->getMessage()]);
            return back()->with('error', 'API request failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::channel ('custom_investor')->error('General Exception:', ['message' => $e->getMessage()]);
            return back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }
}