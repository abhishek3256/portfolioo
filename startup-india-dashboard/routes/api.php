<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FundingRoundController;
use App\Http\Controllers\Api\MilestoneController;
use App\Http\Controllers\Api\StartupController;
use App\Http\Controllers\Api\StartupMetricController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Dashboard stats (public for this demo)
Route::get('/startups/stats', [StartupController::class, 'stats']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Startups
    Route::apiResource('startups', StartupController::class);
    
    // Milestones
    Route::get('/startups/{startup}/milestones', [MilestoneController::class, 'index']);
    Route::post('/startups/{startup}/milestones', [MilestoneController::class, 'store']);
    Route::get('/startups/{startup}/milestones/{milestone}', [MilestoneController::class, 'show']);
    Route::put('/startups/{startup}/milestones/{milestone}', [MilestoneController::class, 'update']);
    Route::delete('/startups/{startup}/milestones/{milestone}', [MilestoneController::class, 'destroy']);
    
    // Funding Rounds
    Route::get('/startups/{startup}/funding-rounds', [FundingRoundController::class, 'index']);
    Route::post('/startups/{startup}/funding-rounds', [FundingRoundController::class, 'store']);
    Route::get('/startups/{startup}/funding-rounds/{fundingRound}', [FundingRoundController::class, 'show']);
    Route::put('/startups/{startup}/funding-rounds/{fundingRound}', [FundingRoundController::class, 'update']);
    Route::delete('/startups/{startup}/funding-rounds/{fundingRound}', [FundingRoundController::class, 'destroy']);
    
    // Metrics
    Route::get('/startups/{startup}/metrics', [StartupMetricController::class, 'index']);
    Route::post('/startups/{startup}/metrics', [StartupMetricController::class, 'store']);
    Route::get('/startups/{startup}/metrics/{metric}', [StartupMetricController::class, 'show']);
    Route::put('/startups/{startup}/metrics/{metric}', [StartupMetricController::class, 'update']);
    Route::delete('/startups/{startup}/metrics/{metric}', [StartupMetricController::class, 'destroy']);
    Route::get('/startups/{startup}/metric-history', [StartupMetricController::class, 'metricHistory']);
});