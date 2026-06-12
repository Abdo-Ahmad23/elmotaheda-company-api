<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Models\ContactMessage; 
use App\Models\Portfolio;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function trackVisit(Request $request)
    {
        $ip = $request->ip(); 
        $today = now()->toDateString(); 

        $alreadyVisitedToday = Visit::where('ip_address', $ip)
                                    ->whereDate('created_at', $today)
                                    ->exists();

        if (!$alreadyVisitedToday) {
            Visit::create([
                'ip_address' => $ip
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Visit tracked successfully'
        ], 200);
    }

    public function getStats()
    {
        $totalVisitors = Visit::count(); 

        $totalMessages = ContactMessage::count();
        $totalPortfolios = Portfolio::count();

        return response()->json([
            'status' => true,
            'data' => [
                'total_visitors' => $totalVisitors,
                'total_messages' => $totalMessages,
                'total_portfolios' => $totalPortfolios
            ]
        ], 200);
    }
}