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

        // Initialize empty collection for startups
        $startups = collect();

        // If there's an AI response, get the startups
        if ($aiResponse) {
            $responseData = json_decode($aiResponse->response_data, true);
            $startupIds = [];

            if (isset($responseData['full_prompt'])) {
                preg_match_all('/Document No: \d+\s*### Content: ({[^}]+})/s', $responseData['full_prompt'], $matches);

                if (!empty($matches[1])) {
                    foreach ($matches[1] as $jsonContent) {
                        $startupData = json_decode($jsonContent, true);
                        if ($startupData && isset($startupData['id'])) {
                            $startupIds[] = $startupData['id'];
                        }
                    }
                }
            }

            $startups = \App\Models\Startup::whereIn('id', $startupIds)->get();

            // Transform startups to include readable names
            $startups = $startups->map(function ($startup) use ($investor) {
                $startup->matching_percentage = $this->calculateMatchingPercentage($investor, $startup);
                $startup->sector_name = $this->getSectorName($startup->company_sector_id);
                $startup->phase_name = $this->getOperationalPhaseName($startup->operational_phase_id);
                $startup->funding_name = $this->getFundingAmountName($startup->funding_amount_id);
                $startup->market_name = $this->getTargetMarketName($startup->target_market_id);
                return $startup;
            })->sortByDesc('matching_percentage');
        }

        // Return the view with all necessary data
        return view('investors.api_test', compact('investor', 'aiResponse', 'startups'));
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
        $url = 'http://85.31.236.242:5000/api/v1/nlp/index/answer/startupversionFullData'; // Replace with actual AI endpoint
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
        $investor = Investor::with(['favouriteSectors', 'favouriteInvestmentStage', 'budgetRange', 'geographicalScope', 'coInvest'])
            ->findOrFail($id);
        $aiResponse = AiResponse::where('investor_id', $investor->id)->latest()->first();

        if ($aiResponse) {
            $responseData = json_decode($aiResponse->response_data, true);
            $startupIds = [];

            if (isset($responseData['full_prompt'])) {
                preg_match_all('/Document No: \d+\s*### Content: ({[^}]+})/s', $responseData['full_prompt'], $matches);

                if (!empty($matches[1])) {
                    foreach ($matches[1] as $jsonContent) {
                        $startupData = json_decode($jsonContent, true);
                        if ($startupData && isset($startupData['id'])) {
                            $startupIds[] = $startupData['id'];
                        }
                    }
                }
            }

            $startups = \App\Models\Startup::whereIn('id', $startupIds)->get();

            // Transform startups to include readable names
            $startups = $startups->map(function ($startup) use ($investor) {
                $startup->matching_percentage = $this->calculateMatchingPercentage($investor, $startup);
                $startup->sector_name = $this->getSectorName($startup->company_sector_id);
                $startup->phase_name = $this->getOperationalPhaseName($startup->operational_phase_id);
                $startup->funding_name = $this->getFundingAmountName($startup->funding_amount_id);
                $startup->market_name = $this->getTargetMarketName($startup->target_market_id);
                return $startup;
            })->sortByDesc('matching_percentage');

        } else {
            $responseData = null;
            $startups = collect();
        }

        return view('investors.ai_response', compact('investor', 'aiResponse', 'responseData', 'startups'));
    }

    public function calculateMatchingPercentage($investor, $startup)
    {
        $scores = [
            'sector' => $this->calculateSectorScore($investor, $startup),
            'stage' => $this->calculateStageScore($investor, $startup),
            'budget' => $this->calculateBudgetScore($investor, $startup),
            'geographic' => $this->calculateGeographicScore($investor, $startup),
            'business' => $this->calculateBusinessMetricsScore($startup),
            'investment' => $this->calculateInvestmentPreferenceScore($investor, $startup)
        ];

        $weights = [
            'sector' => 25,
            'stage' => 20,
            'budget' => 20,
            'geographic' => 15,
            'business' => 10,
            'investment' => 10
        ];

        $totalScore = 0;
        foreach ($scores as $key => $score) {
            $totalScore += ($score * $weights[$key]) / 100;
        }

        return round($totalScore);
    }

    private function calculateSectorScore($investor, $startup)
    {
        $investorSectors = $investor->favouriteSectors->pluck('name')->toArray();
        $startupSector = $this->getSectorName($startup->company_sector_id);

        // Direct match
        if (in_array($startupSector, $investorSectors)) {
            return 100;
        }

        // Related sector match
        if ($this->isSectorRelated($startupSector, $investorSectors)) {
            return 60;
        }

        // Technology sector bonus (if investor interested in tech and startup has tech components)
        if (in_array('Technology', $investorSectors) && $this->hasTechComponent($startupSector)) {
            return 40;
        }

        return 0;
    }

    private function calculateStageScore($investor, $startup)
    {
        $stages = ['Pre-Seed', 'Seed', 'Pre-Series A', 'Series A', 'Series B'];
        $investorStage = $investor->favouriteInvestmentStage->name;
        $startupStage = $this->getOperationalPhaseName($startup->operational_phase_id);

        if ($investorStage === $startupStage) {
            return 100;
        }

        $investorIndex = array_search($investorStage, $stages);
        $startupIndex = array_search($startupStage, $stages);
        $distance = abs($investorIndex - $startupIndex);

        if ($distance === 1)
            return 60;
        if ($distance === 2)
            return 30;
        return 0;
    }

    private function calculateBudgetScore($investor, $startup)
    {
        $budgetRanges = [
            '$ 100K to $ 500K' => ['min' => 100000, 'max' => 500000],
            '$ 500K to $ 1M' => ['min' => 500000, 'max' => 1000000],
            '$ 1M to $ 5M' => ['min' => 1000000, 'max' => 5000000],
            '$ 5M+' => ['min' => 5000000, 'max' => PHP_FLOAT_MAX]
        ];

        $investorBudget = $investor->budgetRange->name;
        $startupFunding = $this->getFundingAmountName($startup->funding_amount_id);

        if ($investorBudget === $startupFunding)
            return 100;

        $investorRange = $budgetRanges[$investorBudget] ?? null;
        $startupRange = $budgetRanges[$startupFunding] ?? null;

        if (!$investorRange || !$startupRange)
            return 0;

        if ($startupRange['min'] <= $investorRange['max']) {
            $overlap = min($investorRange['max'], $startupRange['max']) - max($investorRange['min'], $startupRange['min']);
            $totalRange = $investorRange['max'] - $investorRange['min'];
            return round(($overlap / $totalRange) * 100);
        }

        return 0;
    }

    private function calculateGeographicScore($investor, $startup)
    {
        $marketHierarchy = [
            'Local (UAE)' => ['weight' => 1, 'markets' => ['Local (UAE)']],
            'Gulf' => ['weight' => 2, 'markets' => ['Local (UAE)', 'Gulf']],
            'Regional' => ['weight' => 3, 'markets' => ['Local (UAE)', 'Gulf', 'Regional']]
        ];

        $investorScope = $investor->geographicalScope->name;
        $startupMarket = $this->getTargetMarketName($startup->target_market_id);

        if ($investorScope === $startupMarket)
            return 100;

        $investorMarkets = $marketHierarchy[$investorScope]['markets'] ?? [];
        if (in_array($startupMarket, $investorMarkets)) {
            return 75;
        }

        return 0;
    }

    private function calculateBusinessMetricsScore($startup)
    {
        $score = 0;

        // Revenue growth
        if ($startup->revenue_growth > 100)
            $score += 40;
        elseif ($startup->revenue_growth > 50)
            $score += 30;
        elseif ($startup->revenue_growth > 25)
            $score += 20;
        elseif ($startup->revenue_growth > 0)
            $score += 10;

        // Profitability
        if ($startup->is_profitable)
            $score += 30;

        // Debt status
        if (!$startup->have_debts)
            $score += 30;

        return min($score, 100);
    }

    private function calculateInvestmentPreferenceScore($investor, $startup)
    {
        $score = 0;

        // Co-investment preference
        if ($investor->coInvest->name === $this->getJointInvestmentName($startup->joint_investment)) {
            $score += 50;
        }

        // Investment privacy alignment
        if ($investor->investmentPrivacyOption->name === $startup->privacy_option) {
            $score += 50;
        }

        return $score;
    }

    private function hasTechComponent($sector)
    {
        $techSectors = [
            'Technology',
            'Fintech',
            'HealthTech',
            'Edtech',
            'Cybersecurity',
            'AgriTech',
            'PropTech',
            'Artificial Intelligence'
        ];
        return in_array($sector, $techSectors);
    }

    private function isSectorRelated($startupSector, $investorSectors)
    {
        // Define related sectors
        $relatedSectors = [
            'Technology' => ['Fintech', 'Edtech', 'Artificial Intelligence', 'Cybersecurity'],
            'Fintech' => ['Technology', 'Artificial Intelligence'],
            'HealthTech' => ['Technology', 'Artificial Intelligence'],
            'Edtech' => ['Technology', 'Artificial Intelligence'],
            // Add more related sectors
        ];

        foreach ($investorSectors as $investorSector) {
            if (isset($relatedSectors[$investorSector]) && in_array($startupSector, $relatedSectors[$investorSector])) {
                return true;
            }
        }
        return false;
    }

    private function getSectorName($id)
    {
        $sectors = [
            1 => 'Technology',
            2 => 'Fintech',
            3 => 'HealthTech',
            4 => 'Edtech',
            5 => 'Ecommerce',
            6 => 'Renewable Energy',
            7 => 'Cybersecurity',
            8 => 'AgriTech',
            9 => 'PropTech',
            10 => 'Gaming',
            11 => 'Sports & Fitness',
            12 => 'Logistics & Transportation',
            13 => 'Food & Beverages',
            14 => 'Sustainability',
            15 => 'Artificial Intelligence',
            16 => 'Other'
        ];
        return $sectors[$id] ?? 'Unknown';
    }

    private function getOperationalPhaseName($id)
    {
        $phases = [
            1 => 'Pre-Seed',
            2 => 'Seed',
            3 => 'Pre-Series A',
            4 => 'Series A',
            5 => 'Series B'
        ];
        return $phases[$id] ?? 'Unknown';
    }

    private function getFundingAmountName($id)
    {
        $amounts = [
            1 => '$ 100K to $ 500K',
            2 => '$ 500K to $ 1M',
            3 => '$ 1M to $ 5M',
            4 => '$ 5M+',
            5 => 'Other'
        ];
        return $amounts[$id] ?? 'Unknown';
    }

    private function getTargetMarketName($id)
    {
        $markets = [
            1 => 'Local (UAE)',
            2 => 'Gulf',
            3 => 'Regional'
        ];
        return $markets[$id] ?? 'Unknown';
    }

    private function getJointInvestmentName($id)
    {
        return $id == 1 ? 'yes' : 'no';
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