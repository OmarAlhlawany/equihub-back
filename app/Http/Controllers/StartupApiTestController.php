<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Startup;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class StartupApiTestController extends Controller
{
    public function showTestPage($id)
    {
        $startup = Startup::findOrFail($id);

        // Add these helper methods to transform the data
        $startup->sector_name = $this->getSectorName($startup->company_sector_id);
        $startup->phase_name = $this->getOperationalPhaseName($startup->operational_phase_id);
        $startup->funding_name = $this->getFundingAmountName($startup->funding_amount_id);
        $startup->market_name = $this->getTargetMarketName($startup->target_market_id);

        return view('startups.api_test', compact('startup'));
    }

    public function sendStartupData(Request $request, $id)
    {
        // Retrieve the startup
        $startup = Startup::findOrFail($id);
    
        // Construct API payload
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
                    'employee_count' => $startup->employee_count,
                    'customer_count' => $startup->customer_count,
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
    
        // Prepare client for making API request
        $client = new Client();
        $url = 'http://85.31.236.242:5000/api/v1/nlp/pipeline/startup1o';
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer YOUR_API_KEY'
        ];
    
        try {
            // Log the request payload for debugging
            Log::info('Sending startup data to AI:', ['data' => $data]);
    
            // Send data to AI model
            $response = $client->post($url, [
                'json' => $data,
                'headers' => $headers
            ]);
    
            // Log the AI response for debugging
            Log::info('AI Response:', ['response' => json_decode($response->getBody(), true)]);
    
            // Redirect back with success message
            return back()->with('success', 'Startup data sent successfully for analysis!');
        } catch (\Exception $e) {
            Log::error('Error sending startup data to AI:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to send data: ' . $e->getMessage());
        }
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
}