<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Investor;
use App\Models\Startup;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    /**
     * Display the WhatsApp control panel
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all investors with their phone numbers
        $investors = Investor::whereNotNull('phone_number')
            ->where('phone_number', '!=', '')
            ->orderBy('name')
            ->get(['id', 'name', 'phone_number']);

        // Get statistics for the dashboard
        $totalInvestors = Investor::count();
        $investorsWithPhone = $investors->count();

        Log::info('WhatsApp Dashboard Loaded', [
            'total_investors' => $totalInvestors,
            'investors_with_phone' => $investorsWithPhone,
            'timestamp' => now()->toDateTimeString()
        ]);

        return view('whatsapp.index', compact('investors', 'totalInvestors', 'investorsWithPhone'));
    }

    /**
     * Send PDF report to investor via WhatsApp
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function sendReport(Request $request): JsonResponse
    {
        Log::info('=== WhatsApp Send Report Started ===', [
            'request_data' => $request->all(),
            'timestamp' => now()->toDateTimeString()
        ]);

        try {
            // Validate request
            $request->validate([
                'investor_id' => 'required|exists:investors,id',
                'language' => 'required|in:en,ar',
                'message' => 'nullable|string|max:1000'
            ]);

            Log::info('Request validation passed', [
                'investor_id' => $request->investor_id,
                'language' => $request->language,
                'message_length' => strlen($request->message ?? '')
            ]);

            // Get investor
            $investor = Investor::find($request->investor_id);
            if (!$investor) {
                Log::error('Investor not found', ['investor_id' => $request->investor_id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Investor not found'
                ], 404);
            }

            Log::info('Investor found', [
                'investor_id' => $investor->id,
                'investor_name' => $investor->name,
                'phone_number' => $this->maskPhoneNumber($investor->phone_number ?? ''),
                'has_phone' => !empty($investor->phone_number)
            ]);

            // Check if investor has phone number
            if (empty($investor->phone_number)) {
                Log::warning('Investor has no phone number', [
                    'investor_id' => $investor->id,
                    'investor_name' => $investor->name
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Investor does not have a phone number'
                ], 400);
            }

            // Generate PDF report
            Log::info('Starting PDF generation', [
                'investor_id' => $investor->id,
                'language' => $request->language
            ]);

            $pdfContent = $this->generatePdfReport($investor, $request->language);

            if (!$pdfContent) {
                Log::error('PDF generation failed', [
                    'investor_id' => $investor->id,
                    'language' => $request->language
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate PDF report'
                ], 500);
            }

            Log::info('PDF generated successfully', [
                'investor_id' => $investor->id,
                'pdf_size_bytes' => strlen($pdfContent),
                'pdf_size_kb' => round(strlen($pdfContent) / 1024, 2)
            ]);

            // Prepare message text
            $customMessage = $request->message;
            $defaultMessage = $request->language === 'ar'
                ? "مرحباً {$investor->name}،\n\nنرسل لك تقرير الاستثمار المخصص من منصة إكويهب.\n\nشكراً لك."
                : "Hello {$investor->name},\n\nWe are sending you your personalized investment report from Angeleast platform.\n\nThank you.";

            $messageText = $customMessage ?: $defaultMessage;

            Log::info('Message prepared', [
                'investor_id' => $investor->id,
                'message_type' => $customMessage ? 'custom' : 'default',
                'message_length' => strlen($messageText),
                'language' => $request->language
            ]);

            // Send WhatsApp message
            Log::info('Starting WhatsApp message send', [
                'investor_id' => $investor->id,
                'phone_number' => $this->maskPhoneNumber($investor->phone_number)
            ]);

            $result = $this->sendWhatsAppMessage(
                $investor->phone_number,
                $messageText,
                $pdfContent,
                $investor,
                $request->language
            );

            Log::info('WhatsApp send result', [
                'investor_id' => $investor->id,
                'success' => $result['success'],
                'result' => $result
            ]);

            if ($result['success']) {
                Log::info('=== WhatsApp Send Report Completed Successfully ===', [
                    'investor_id' => $investor->id,
                    'investor_name' => $investor->name,
                    'phone_number' => $this->maskPhoneNumber($investor->phone_number),
                    'language' => $request->language,
                    'timestamp' => now()->toDateTimeString()
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Report sent successfully to ' . $investor->name,
                    'debug_info' => [
                        'investor_id' => $investor->id,
                        'phone_number' => $this->maskPhoneNumber($investor->phone_number),
                        'pdf_size_kb' => round(strlen($pdfContent) / 1024, 2),
                        'message_length' => strlen($messageText),
                        'api_response' => $result['data'] ?? null
                    ]
                ]);
            } else {
                Log::error('=== WhatsApp Send Report Failed ===', [
                    'investor_id' => $investor->id,
                    'error' => $result['error'],
                    'timestamp' => now()->toDateTimeString()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send report: ' . $result['error'],
                    'debug_info' => [
                        'investor_id' => $investor->id,
                        'phone_number' => $this->maskPhoneNumber($investor->phone_number),
                        'error_details' => $result['error']
                    ]
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('=== WhatsApp Send Report Exception ===', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'timestamp' => now()->toDateTimeString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
                'debug_info' => [
                    'error_type' => get_class($e),
                    'error_line' => $e->getLine(),
                    'error_file' => basename($e->getFile())
                ]
            ], 500);
        }
    }

    /**
     * Generate PDF report for the investor using existing PDF controllers
     * 
     * @param Investor $investor
     * @param string $language
     * @return string|null Base64 encoded PDF content
     */
    private function generatePdfReport(Investor $investor, string $language = 'en'): ?string
    {
        try {
            Log::info('Generating PDF using existing controllers', [
                'investor_id' => $investor->id,
                'language' => $language
            ]);

            // Use existing PDF controllers to generate the exact same PDFs
            if ($language === 'ar') {
                $pdfController = new ArabicPdfReportController();
            } else {
                $pdfController = new EnglishPdfReportController();
            }

            // Get the PDF response from the existing controller
            $pdfResponse = $pdfController->downloadAiResponse($investor);

            // Check if the response is successful and contains PDF content
            if ($pdfResponse instanceof \Illuminate\Http\Response && $pdfResponse->getStatusCode() === 200) {
                // Get the PDF content from the response
                $pdfContent = $pdfResponse->getContent();

                // Convert to base64 for WhatsApp API
                $base64Content = base64_encode($pdfContent);

                Log::info('PDF generated successfully using existing controller', [
                    'investor_id' => $investor->id,
                    'language' => $language,
                    'pdf_size_bytes' => strlen($pdfContent),
                    'pdf_size_kb' => round(strlen($pdfContent) / 1024, 2)
                ]);

                return $base64Content;
            }

            Log::error('PDF controller returned invalid response', [
                'investor_id' => $investor->id,
                'language' => $language,
                'response_type' => get_class($pdfResponse),
                'status_code' => method_exists($pdfResponse, 'getStatusCode') ? $pdfResponse->getStatusCode() : 'unknown'
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('PDF generation failed using existing controller', [
                'investor_id' => $investor->id,
                'language' => $language,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return null;
        }
    }

    /**
     * Send WhatsApp message with PDF attachment using wasenderapi
     * 
     * @param string $phoneNumber
     * @param string $messageText
     * @param string $pdfContent Base64 encoded PDF
     * @param Investor $investor
     * @param string $language
     * @return array
     */
    private function sendWhatsAppMessage(
        string $phoneNumber,
        string $messageText,
        string $pdfContent,
        Investor $investor,
        string $language
    ): array {
        try {
            // Get configuration from services config
            $apiUrl = config('services.wasender.api_url', 'https://wasenderapi.com/api/send-message');
            $apiKey = config('services.wasender.api_key');

            // Validate environment variables are set
            if (empty($apiUrl) || empty($apiKey)) {
                return [
                    'success' => false,
                    'error' => 'WhatsApp API configuration is incomplete. Please check WASENDER_API_KEY in .env file'
                ];
            }

            // Format phone number for international format
            $formattedPhone = $this->formatPhoneNumber($phoneNumber);

            // Generate filename for the PDF attachment
            $filename = sprintf(
                'investor_report_%s_%s_%s.pdf',
                $language,
                str_replace(' ', '_', $investor->name),
                now()->format('Y-m-d_H-i-s')
            );

            // First, try sending just the text message to see if that works
            Log::info('Sending WhatsApp Text Message First', [
                'api_url' => $apiUrl,
                'phone_number' => $this->maskPhoneNumber($formattedPhone),
                'text_length' => strlen($messageText)
            ]);

            $textPayload = [
                'to' => $formattedPhone,
                'text' => $messageText
            ];

            $textResponse = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->post($apiUrl, $textPayload);

            Log::info('Text Message Response', [
                'status' => $textResponse->status(),
                'response' => $textResponse->json()
            ]);

            if (!$textResponse->successful()) {
                $errorResponse = $textResponse->json();
                $errorMessage = $errorResponse['message'] ?? $errorResponse['error'] ?? 'Failed to send text message';

                return [
                    'success' => false,
                    'error' => "Text message failed ({$textResponse->status()}): {$errorMessage}"
                ];
            }

            // Text message sent successfully, now try to send the document
            // Wait 6 seconds to avoid rate limiting (API requires 5+ seconds)
            sleep(6);

            Log::info('Now sending document separately', [
                'filename' => $filename,
                'pdf_size_kb' => round(strlen($pdfContent) * 3 / 4 / 1024, 2)
            ]);

            // Save PDF temporarily and create a publicly accessible URL
            $tempFileName = 'temp_' . uniqid() . '_' . $filename;
            $tempFilePath = 'temp/' . $tempFileName;
            $fullTempPath = storage_path('app/public/' . $tempFilePath);

            // Ensure temp directory exists
            if (!file_exists(dirname($fullTempPath))) {
                mkdir(dirname($fullTempPath), 0755, true);
            }

            // Save PDF file temporarily
            file_put_contents($fullTempPath, base64_decode($pdfContent));

            // For development: Use ngrok public URL
            // For production: Use your actual domain
            $ngrokUrl = 'https://dashboard.angeleast.net';
            $documentUrl = $ngrokUrl . '/storage/' . $tempFilePath;

            Log::info('Document URL created', [
                'document_url' => $documentUrl,
                'file_exists' => file_exists($fullTempPath),
                'file_size' => file_exists($fullTempPath) ? filesize($fullTempPath) : 0
            ]);

            // Use exact wasenderapi format from documentation
            $documentPayload = [
                'to' => $formattedPhone,
                'text' => '📄 Your investment report is attached',
                'documentUrl' => $documentUrl,
                'fileName' => $filename
            ];

            $documentResponse = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])
                ->post($apiUrl, $documentPayload);

            Log::info('Document Response', [
                'status' => $documentResponse->status(),
                'response' => $documentResponse->json(),
                'document_url' => $documentUrl
            ]);

            // Don't clean up the file immediately - wasenderapi needs time to download it
            // The file will be cleaned up by a scheduled job or manual cleanup
            // if (file_exists($fullTempPath)) {
            //     unlink($fullTempPath);
            //     Log::info('Temporary PDF file cleaned up', ['file' => $tempFilePath]);
            // }

            Log::info('Document sent successfully, file kept for wasenderapi download', [
                'document_url' => $documentUrl,
                'file_path' => $fullTempPath
            ]);

            return [
                'success' => true,
                'data' => [
                    'text_response' => $textResponse->json(),
                    'document_response' => $documentResponse->json()
                ]
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp API Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'phone_number' => $this->maskPhoneNumber($phoneNumber ?? '')
            ]);

            return [
                'success' => false,
                'error' => 'API communication error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Format phone number for WhatsApp API (international format)
     * 
     * @param string $phoneNumber
     * @return string
     */
    private function formatPhoneNumber(string $phoneNumber): string
    {
        // Remove all non-digit characters
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);

        // If it doesn't start with a country code and is 10 digits, assume Saudi Arabia (+966)
        // Adjust this logic based on your primary country/region
        if (strlen($cleaned) === 10 && !str_starts_with($cleaned, '966')) {
            $cleaned = '966' . $cleaned;
        }

        // Remove leading zeros after country code
        if (str_starts_with($cleaned, '9660')) {
            $cleaned = '966' . substr($cleaned, 4);
        }

        // Add + sign as required by wasenderapi
        return '+' . $cleaned;
    }

    /**
     * Mask phone number for logging (privacy protection)
     * 
     * @param string $phoneNumber
     * @return string
     */
    private function maskPhoneNumber(string $phoneNumber): string
    {
        if (strlen($phoneNumber) <= 4) {
            return str_repeat('*', strlen($phoneNumber));
        }

        return substr($phoneNumber, 0, 3) . str_repeat('*', strlen($phoneNumber) - 6) . substr($phoneNumber, -3);
    }

    /**
     * Test API connection to wasenderapi
     * For debugging purposes only
     * 
     * @return JsonResponse
     */
    public function testApi()
    {
        try {
            $apiUrl = config('services.wasender.api_url', 'https://wasenderapi.com/api/send-message');
            $apiKey = config('services.wasender.api_key');

            Log::info('Testing WhatsApp API Connection', [
                'api_url' => $apiUrl,
                'api_key_set' => !empty($apiKey),
                'api_key_length' => strlen($apiKey ?? ''),
                'timestamp' => now()->toDateTimeString()
            ]);

            if (empty($apiKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'API key not configured'
                ], 400);
            }

            // Test with a simple text message to a test number
            $testPayload = [
                'to' => '+201020973478', // Test number
                'text' => 'API Test from Angeleast - ' . now()->toDateTimeString()
            ];

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->post($apiUrl, $testPayload);

            Log::info('API Test Response', [
                'status' => $response->status(),
                'response_body' => $response->json(),
                'success' => $response->successful()
            ]);

            return response()->json([
                'success' => $response->successful(),
                'status_code' => $response->status(),
                'response' => $response->json(),
                'message' => $response->successful() ? 'API connection successful' : 'API connection failed'
            ]);

        } catch (\Exception $e) {
            Log::error('API Test Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'API test failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test document sending
     * For debugging purposes only
     * 
     * @return JsonResponse
     */
    public function testDocument()
    {
        try {
            $apiUrl = config('services.wasender.api_url', 'https://wasenderapi.com/api/send-message');
            $apiKey = config('services.wasender.api_key');

            // Create a simple test PDF
            $testPdfContent = base64_encode('Test PDF Content - This is not a real PDF');

            $testPayload = [
                'to' => '+201020973478',
                'text' => 'Document Test from Angeleast - ' . now()->toDateTimeString(),
                'document' => $testPdfContent,
                'filename' => 'test_document.pdf'
            ];

            Log::info('Testing Document Send', [
                'api_url' => $apiUrl,
                'payload_keys' => array_keys($testPayload),
                'document_size' => strlen($testPdfContent)
            ]);

            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->post($apiUrl, $testPayload);

            Log::info('Document Test Response', [
                'status' => $response->status(),
                'response_body' => $response->json(),
                'success' => $response->successful()
            ]);

            return response()->json([
                'success' => $response->successful(),
                'status_code' => $response->status(),
                'response' => $response->json(),
                'message' => $response->successful() ? 'Document test successful' : 'Document test failed'
            ]);

        } catch (\Exception $e) {
            Log::error('Document Test Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Document test failed: ' . $e->getMessage()
            ], 500);
        }
    }
}