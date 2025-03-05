<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Startup;
use Illuminate\Support\Facades\Log;

class StartupApiTestController extends Controller
{
    /**
     * عرض صفحة الاختبار لاستقبال البيانات
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

        // تجهيز البيانات للعرض
        $data = [
            'id'                      => $startup->id,
            'name'                    => $startup->name,
            'email'                   => $startup->email,
            'phone_number'            => $startup->phone_number,
            'company'                 => $startup->company,
            'website'                 => $startup->website,
            'product_service_description' => $startup->product_service_description,
            'category'                => optional($startup->companySector)->name, // تعديل ليتناسب مع API
            'operational_phase'       => optional($startup->operationalPhase)->name,
            'problem_solved'          => $startup->problem_solved,
            'funding_amount'          => optional($startup->fundingAmount)->name,
            'funding_used'            => $startup->funding_used,
            'previous_funding_source' => optional($startup->previousFundingSource)->name,
            'investment_type'         => 'SAFE', // افتراضًا أو جلبه من قاعدة البيانات
            'existing_partners'       => optional($startup->existingPartners)->name,
            'annual_revenue'          => $startup->monthly_revenue * 12, // تحويل الإيرادات الشهرية إلى سنوية
            'is_profitable'           => optional($startup->isProfitable)->name,
            'company_valuation'       => '4314922', // افتراضي أو جلبه من قاعدة البيانات
            'break_even_goal'         => $startup->break_even_point, // تأكد من القيمة
            'have_debts'              => optional($startup->haveDebts)->name,
            'annual_growth'           => $startup->revenue_growth, // نسبة النمو السنوي
            'exit_strategy'           => $startup->exit_strategy_details,
            'has_exit_strategy'       => optional($startup->hasExitStrategy)->name
        ];

        return view('startups.api_test', compact('startup', 'data'));
    }

    /**
     * إرسال بيانات الشركة الناشئة إلى API الذكاء الاصطناعي
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

        // تجهيز البيانات للإرسال
        $data = [
            'id'                      => $startup->id,
            'name'                    => $startup->name,
            'email'                   => $startup->email,
            'phone_number'            => $startup->phone_number,
            'company'                 => $startup->company,
            'website'                 => $startup->website,
            'product_service_description' => $startup->product_service_description,
            'category'                => optional($startup->companySector)->name,
            'operational_phase'       => optional($startup->operationalPhase)->name,
            'problem_solved'          => $startup->problem_solved,
            'funding_amount'          => optional($startup->fundingAmount)->name,
            'funding_used'            => $startup->funding_used,
            'previous_funding_source' => optional($startup->previousFundingSource)->name,
            'investment_type'         => 'SAFE',
            'existing_partners'       => optional($startup->existingPartners)->name,
            'annual_revenue' => strval($startup->monthly_revenue * 12),
            'is_profitable'           => optional($startup->isProfitable)->name,
            'company_valuation'       => '4314922',
            'break_even_goal'         => $startup->break_even_point,
            'have_debts'              => optional($startup->haveDebts)->name,
            'annual_growth' => strval($startup->revenue_growth),
            'exit_strategy' => (string) ($startup->exit_strategy_details ?? ''),
            'has_exit_strategy'       => optional($startup->hasExitStrategy)->name
        ];
                // تأكيد أن البيانات مرسلة في key اسمه startup_data
        $payload = [
            'startup_data' => [$data]
        ];

        // API Client
        $client = new Client();
        $url = 'http://85.31.236.242:5000/api/v1/nlp/pipeline/startup1o';
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer YOUR_API_KEY' // استبدل بمفتاح API الصحيح
        ];

        try {
            // Log البيانات قبل الإرسال
            Log::channel('custom_startup')->info('Final Payload Sent:', ['payload' => $payload]);

            // إرسال البيانات إلى الذكاء الاصطناعي
            $response = $client->post($url, [
                'json'    => $payload,
                'headers' => $headers
            ]);

            // استقبال الرد
            $body = json_decode($response->getBody(), true);

            // Log الرد
            Log::channel('custom_startup')->info('AI Response:', ['response' => $body]);

            return back()->with('success', 'تم إرسال بيانات الشركة بنجاح!');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::channel('custom_startup')->error('GuzzleHttp RequestException:', ['message' => $e->getMessage()]);
            return back()->with('error', 'فشل طلب الـ API: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::channel('custom_startup')->error('General Exception:', ['message' => $e->getMessage()]);
            return back()->with('error', 'حدث خطأ غير متوقع: ' . $e->getMessage());
        }
    }
    }