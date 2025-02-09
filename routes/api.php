<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InvestorController;
use App\Http\Controllers\Api\StartupController;
use App\Http\Controllers\Api\DynamicTableApiController;

Route::post('/investors', [InvestorController::class, 'store']);
Route::get('/investors/{id}', [InvestorController::class, 'show']);
Route::post('/startups', [StartupController::class, 'store']);
Route::get('/startups/{id}', [StartupController::class, 'show']);
Route::get('/test', function() {
    return response()->json(['message' => 'API is working']);

});

Route::get('/dynamic-tables', [DynamicTableApiController::class, 'getTables']);
