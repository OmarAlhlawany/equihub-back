<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\StartupController;
use App\Http\Controllers\DynamicTableController;
use App\Http\Controllers\InvestorInsightController;
use App\Http\Controllers\StartupInsightController;
use App\Http\Controllers\InvestorApiTestController;
use App\Http\Controllers\StartupApiTestController;
use App\Http\Controllers\ArabicPdfReportController;
use App\Http\Controllers\EnglishPdfReportController;
use App\Http\Controllers\WhatsAppController;


// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login'); // Redirects to /login
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Group routes that require authentication
Route::middleware(['auth'])->group(function () {

    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Investors Routes
    Route::get('/investors', [InvestorController::class, 'index'])->name('investors');
    Route::get('/investors/create', [InvestorController::class, 'create'])->name('investors.create');
    Route::post('/investors', [InvestorController::class, 'store'])->name('investors.store');
    Route::get('/investors/{investor}/edit', [InvestorController::class, 'edit'])->name('investors.edit');
    Route::put('/investors/{investor}', [InvestorController::class, 'update'])->name('investors.update');
    Route::get('/investors/{investor}', [InvestorController::class, 'show'])->name('investors.show');
    Route::delete('/investors/{investor}', [InvestorController::class, 'destroy'])->name('investors.destroy');

    // Arabic PDF Report Routes
    Route::get('/investors/{investor}/pdf/ai-response/ar', [ArabicPdfReportController::class, 'downloadAiResponse'])
        ->name('investors.pdf.ai_response.ar');

    // English PDF Report Routes
    Route::get('/investors/{investor}/pdf/ai-response/en', [EnglishPdfReportController::class, 'downloadAiResponse'])
        ->name('investors.pdf.ai_response.en');

    // WhatsApp Report Routes
    Route::get('/whatsapp', [WhatsAppController::class, 'index'])
        ->name('whatsapp.index');
    Route::post('/whatsapp/send-report', [WhatsAppController::class, 'sendReport'])
        ->name('whatsapp.send.report');
    Route::get('/whatsapp/test-api', [WhatsAppController::class, 'testApi'])
        ->name('whatsapp.test.api');
    Route::get('/whatsapp/test-document', [WhatsAppController::class, 'testDocument'])->name('whatsapp.test-document');

    // Startups Routes
    Route::get('/startups', [StartupController::class, 'index'])->name('startups');
    Route::get('/startups/create', [StartupController::class, 'create'])->name('startups.create');
    Route::post('/startups', [StartupController::class, 'store'])->name('startups.store');
    Route::get('/startups/{startup}/edit', [StartupController::class, 'edit'])->name('startups.edit');
    Route::put('/startups/{startup}', [StartupController::class, 'update'])->name('startups.update');
    Route::get('/startups/{startup}', [StartupController::class, 'show'])->name('startups.show');
    Route::delete('/startups/{startup}', [StartupController::class, 'destroy'])->name('startups.destroy');

    // Investor Insights Route
    Route::get('/investor-insights', [InvestorInsightController::class, 'index'])->name('investor-insights');

    // Startup Insights Route
    Route::get('/startup-insights', [StartupInsightController::class, 'index'])->name('startup-insights');


    // Users Routes
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/dynamic-tables', [DynamicTableController::class, 'index'])->name('dynamic-tables.index');
    Route::post('/dynamic-tables/store', [DynamicTableController::class, 'store'])->name('dynamic-tables.store');
    Route::delete('/dynamic-tables/{table}/{id}', [DynamicTableController::class, 'destroy'])->name('dynamic-tables.destroy');


    Route::get('/investors/{id}/test-api', [InvestorApiTestController::class, 'showTestPage'])->name('investor.api.test');
    Route::post('/investors/{id}/send-to-ai', [InvestorApiTestController::class, 'sendInvestorData'])->name('investor.api.test.send');
    Route::get('investors/{id}/ai-response', [InvestorApiTestController::class, 'viewAiResponse'])->name('investor.response.view');

    Route::get('/startups/{id}/test-api', [StartupApiTestController::class, 'showTestPage'])->name('startup.api.test');
    Route::post('/startups/{id}/send-to-ai', [StartupApiTestController::class, 'sendStartupData'])->name('startup.api.test.send');

});

