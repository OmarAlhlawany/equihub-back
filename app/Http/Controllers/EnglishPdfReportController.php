<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Startup;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class EnglishPdfReportController extends Controller
{
    /**
     * Generate an English PDF report for an investor's startup matches
     * 
     * @param Investor $investor
     * @return \Illuminate\Http\Response
     */
    public function downloadAiResponse(Investor $investor)
    {
        try {
            Log::info('English PDF Download Initiated', [
                'investor_id' => $investor->id,
                'investor_name' => $investor->name
            ]);

            // Retrieve the AI response data
            $aiResponse = $investor->aiResponses()->latest()->first();

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

                $startups = Startup::whereIn('id', $startupIds)->get();

                // Transform startups to include readable names and matching percentage
                $startups = $startups->map(function ($startup) use ($investor) {
                    $startup->matching_percentage = $this->calculateMatchingPercentage($investor, $startup);
                    $startup->sector_name = $this->getSectorName($startup->company_sector_id);
                    $startup->phase_name = $this->getOperationalPhaseName($startup->operational_phase_id);
                    $startup->funding_name = $this->getFundingAmountName($startup->funding_amount_id);
                    $startup->market_name = $this->getTargetMarketName($startup->target_market_id);
                    return $startup;
                })->sortByDesc('matching_percentage');
            }

            // Verify view exists
            if (!View::exists('investors.pdf.ai_response_en')) {
                Log::error("English PDF view not found");
                return back()->with('error', 'PDF template not found');
            }

            // Generate PDF filename
            $filename = sprintf(
                'investor_matches_en_%s_%s.pdf',
                str_replace(' ', '_', $investor->name),
                now()->format('Y-m-d_H-i-s')
            );

            // Generate PDF using Snappy
            $pdf = SnappyPdf::loadView('investors.pdf.ai_response_en', [
                'investor' => $investor,
                'startups' => $startups,
                'aiResponse' => $aiResponse
            ]);

            // Optional: Set PDF options
            $pdf->setOption('page-size', 'A4')
                ->setOption('margin-top', 10)
                ->setOption('margin-right', 10)
                ->setOption('margin-bottom', 10)
                ->setOption('margin-left', 10)
                ->setOption('encoding', 'UTF-8')
                ->setOption('enable-local-file-access', true);

            Log::info('English PDF Generated Successfully', [
                'filename' => $filename
            ]);

            // Download PDF
            return $pdf->download($filename);
        } catch (\Exception $e) {
            // Log detailed error
            Log::error('English PDF Generation Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return user-friendly error
            return back()->with('error', 'Failed to create PDF report. Please try again later.');
        }
    }

    /**
     * Calculate matching percentage between investor and startup
     * 
     * @param Investor $investor
     * @param Startup $startup
     * @return float
     */
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
        $investorStage = optional($investor->favouriteInvestmentStage)->name;
        $startupStage = $this->getOperationalPhaseName($startup->operational_phase_id);

        // Direct stage match
        if ($investorStage === $startupStage) {
            return 100;
        }

        // Adjacent stage match
        $stageOrder = [
            'Seed' => 1,
            'Early Stage' => 2,
            'Growth Stage' => 3,
            'Expansion Stage' => 4,
            'Mature Stage' => 5
        ];

        if (isset($stageOrder[$investorStage]) && isset($stageOrder[$startupStage])) {
            $stageDiff = abs($stageOrder[$investorStage] - $stageOrder[$startupStage]);
            return max(0, 100 - ($stageDiff * 30));
        }

        return 0;
    }

    private function calculateBudgetScore($investor, $startup)
    {
        $investorBudget = optional($investor->budgetRange)->name;
        $startupFunding = $this->getFundingAmountName($startup->funding_amount_id);

        // Direct budget match
        if ($investorBudget === $startupFunding) {
            return 100;
        }

        // Budget range match
        $budgetRanges = [
            'Small' => 1,
            'Medium' => 2,
            'Large' => 3
        ];

        if (isset($budgetRanges[$investorBudget]) && isset($budgetRanges[$startupFunding])) {
            $budgetDiff = abs($budgetRanges[$investorBudget] - $budgetRanges[$startupFunding]);
            return max(0, 100 - ($budgetDiff * 40));
        }

        return 0;
    }

    private function calculateGeographicScore($investor, $startup)
    {
        $investorScope = optional($investor->geographicalScope)->name;
        $startupScope = $this->getTargetMarketName($startup->target_market_id);

        // Direct geographic match
        if ($investorScope === $startupScope) {
            return 100;
        }

        // Regional match
        $geographicRegions = [
            'Local' => 1,
            'Regional' => 2,
            'Global' => 3
        ];

        if (isset($geographicRegions[$investorScope]) && isset($geographicRegions[$startupScope])) {
            $scopeDiff = abs($geographicRegions[$investorScope] - $geographicRegions[$startupScope]);
            return max(0, 100 - ($scopeDiff * 40));
        }

        return 0;
    }

    private function calculateBusinessMetricsScore($startup)
    {
        $score = 0;

        // Revenue growth
        $revenueGrowth = $startup->revenue_growth ?? 0;
        $score += min(40, $revenueGrowth);

        // Profitability
        $score += $startup->is_profitable ? 30 : 0;

        // Debt status
        $score += $startup->have_debts ? 0 : 30;

        return $score;
    }

    private function calculateInvestmentPreferenceScore($investor, $startup)
    {
        $score = 0;

        // Co-investment preference
        $coInvestPreference = optional($investor->coInvest)->name;
        $startupJointInvestment = $startup->joint_investment == 1 ? 'Open' : 'Closed';

        if ($coInvestPreference === $startupJointInvestment) {
            $score += 100;
        }

        return $score;
    }

    private function hasTechComponent($sector)
    {
        $techSectors = ['Technology', 'IT', 'Software', 'AI', 'Machine Learning', 'Robotics'];
        return in_array($sector, $techSectors);
    }

    private function isSectorRelated($startupSector, $investorSectors)
    {
        $sectorRelations = [
            'Technology' => ['IT', 'Software', 'AI', 'Machine Learning', 'Robotics'],
            'Finance' => ['Fintech', 'Banking', 'Investment'],
            'Healthcare' => ['Biotech', 'Medical Technology', 'Pharmaceuticals'],
            'Education' => ['E-learning', 'EdTech', 'Training'],
            'Energy' => ['Renewable Energy', 'Sustainability', 'Green Technology']
        ];

        foreach ($investorSectors as $investorSector) {
            if (
                isset($sectorRelations[$investorSector]) &&
                in_array($startupSector, $sectorRelations[$investorSector])
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get sector name
     * 
     * @param int|null $sectorId
     * @return string
     */
    private function getSectorName(?int $sectorId): string
    {
        return $sectorId
            ? \App\Models\CompanySector::find($sectorId)?->name
            : 'Not Specified';
    }

    /**
     * Get operational phase name
     * 
     * @param int|null $phaseId
     * @return string
     */
    private function getOperationalPhaseName(?int $phaseId): string
    {
        return $phaseId
            ? \App\Models\OperationalPhase::find($phaseId)?->name
            : 'Not Specified';
    }

    /**
     * Get funding amount name
     * 
     * @param int|null $fundingId
     * @return string
     */
    private function getFundingAmountName(?int $fundingId): string
    {
        return $fundingId
            ? \App\Models\FundingAmount::find($fundingId)?->name
            : 'Not Specified';
    }

    /**
     * Get target market name
     * 
     * @param int|null $marketId
     * @return string
     */
    private function getTargetMarketName(?int $marketId): string
    {
        return $marketId
            ? \App\Models\TargetMarket::find($marketId)?->name
            : 'Not Specified';
    }
}
