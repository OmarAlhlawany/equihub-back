<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Investor;
use App\Models\AiResponse;
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
        // Retrieve the investor from the database
        $investor = Investor::findOrFail($id);

        // Get the latest AI response for the investor if it exists
        $aiResponse = AiResponse::where('investor_id', $investor->id)->latest()->first();

        // Return the view with investor and aiResponse data
        return view('investors.api_test', compact('investor', 'aiResponse'));
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
        // Retrieve the investor and related models for sending data to AI
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
            'json_data' => [  // Add this wrapper
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
            'limit' => 5  // Optional field to set a limit (if required by the API)
        ];

        // Prepare client for making API request
        $client = new Client();
        $url = 'http://85.31.236.242:5000/api/v1/nlp/index/answer/startups'; // Replace with actual AI endpoint
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json', // Ensuring the content type is set correctly
            'Authorization' => 'Bearer YOUR_API_KEY' // Add actual API key if required
        ];

        try {
            // Log the request payload for debugging
            Log::channel('custom_investor')->info('Sending startup data to AI:', ['data' => $data]);

            // Send data to AI model
            $response = $client->post($url, [
                'json' => $data,
                'headers' => $headers
            ]);
            // Log the raw AI response (before decoding)
            Log::channel('custom_investor')->info('AI Raw Response:', ['response' => $response->getBody()]);

            // Decode response from AI
            $body = json_decode($response->getBody(), true);

            // Store the AI response or update the existing one
            AiResponse::updateOrCreate(
                ['investor_id' => $investor->id], // Update the existing response or create a new one
                ['response_data' => json_encode($body)] // Save the response as-is for now
            );

            // Log the AI response for debugging
            Log::channel('custom_investor')->info('AI Response:', ['response' => $body]);

            // Redirect back with success message and AI response data
            return back()->with('success', 'Investor data sent successfully!')->with('api_response', $body);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Handle Guzzle-specific exceptions
            Log::channel('custom_investor')->error('GuzzleHttp RequestException:', ['message' => $e->getMessage()]);
            return back()->with('error', 'API request failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Handle any other general exceptions
            Log::channel('custom_investor')->error('General Exception:', ['message' => $e->getMessage()]);
            return back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }

    /**
     * View the AI response for the investor.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function viewAiResponse($id)
{
    // Retrieve the investor and their latest AI response
    $investor = Investor::findOrFail($id);
    $aiResponse = AiResponse::where('investor_id', $investor->id)->latest()->first();

    // Check if AI response exists
    if ($aiResponse) {
        // Decode the response JSON data
        $responseData = json_decode($aiResponse->response_data, true);

        // Log the raw response data for debugging
        Log::channel('custom_investor')->info('AI Response Data:', ['response_data' => $responseData]);

    } else {
        $responseData = null;
    }

    // Pass data to the view
    return view('investors.ai_response', compact('investor', 'aiResponse', 'responseData'));
}


    // Helper function to decode Unicode characters
    private function decodeUnicode($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->decodeUnicode($value);
            }
        } elseif (is_string($data)) {
            $data = json_decode('"' . $data . '"');  // Decode the Unicode characters
        }

        return $data;
    }
}
