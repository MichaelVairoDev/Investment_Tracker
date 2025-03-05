<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $portfolios = auth()->user()->portfolios()
            ->withCount('investments')
            ->withSum('investments', 'current_value')
            ->withSum('investments', 'total_invested')
            ->get();

        $totalInvested = $portfolios->sum('investments_sum_total_invested') ?? 0;
        $totalValue = $portfolios->sum('investments_sum_current_value') ?? 0;
        $totalProfitLoss = $totalValue - $totalInvested;
        $totalProfitLossPercentage = $totalInvested > 0 ? ($totalProfitLoss / $totalInvested) * 100 : 0;

        return view('dashboard', compact(
            'portfolios',
            'totalInvested',
            'totalValue',
            'totalProfitLoss',
            'totalProfitLossPercentage'
        ));
    }
}
