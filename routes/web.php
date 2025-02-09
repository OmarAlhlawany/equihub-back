<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\StartupController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\DynamicTableController;


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
    
    // Startups Routes
    Route::get('/startups', [StartupController::class, 'index'])->name('startups');
    Route::get('/startups/create', [StartupController::class, 'create'])->name('startups.create');
    Route::post('/startups', [StartupController::class, 'store'])->name('startups.store');
    Route::get('/startups/{startup}/edit', [StartupController::class, 'edit'])->name('startups.edit');
    Route::put('/startups/{startup}', [StartupController::class, 'update'])->name('startups.update');
    Route::get('/startups/{startup}', [StartupController::class, 'show'])->name('startups.show');
    Route::delete('/startups/{startup}', [StartupController::class, 'destroy'])->name('startups.destroy');

    // Insights Route
    Route::get('/insights', [InsightController::class, 'index'])->name('insights');

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

});
