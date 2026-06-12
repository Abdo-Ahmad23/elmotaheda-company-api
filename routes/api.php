<?php

use App\Http\Controllers\Api\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\DashboardController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/portfolios', [PortfolioController::class, 'index']);
Route::get('/portfolios/{id}', [PortfolioController::class, 'show']);
Route::post('/contact-us', [ContactMessageController::class, 'store']);
Route::post('/track-visit', [DashboardController::class, 'trackVisit']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/contact-messages', [ContactMessageController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/admin-profile', function (Request $request) {
        return response()->json([
            'status' => true,
            'user' => $request->user()
        ]);
    });

    Route::post('/portfolios', [PortfolioController::class, 'store']);
    Route::put('/portfolios/{id}', [PortfolioController::class, 'update']);
    Route::delete('/portfolios/{id}', [PortfolioController::class, 'destroy']);
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
    Route::delete('/contact-messages/{id}', [ContactMessageController::class, 'destroy']);

    Route::get('/admins', [AdminController::class, 'index']);
    Route::post('/admins', [AdminController::class, 'store']);
    Route::delete('/admins/{id}', [AdminController::class, 'destroy']);
});