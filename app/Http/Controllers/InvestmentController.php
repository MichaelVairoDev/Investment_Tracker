<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InvestmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $portfolio = $request->route('portfolio');
            if ($portfolio->user_id !== auth()->id()) {
                abort(403, 'No tienes permiso para acceder a este portafolio.');
            }
            return $next($request);
        });
    }

    public function index(Portfolio $portfolio): View
    {
        $investments = $portfolio->investments()
            ->withCount('transactions')
            ->orderBy('symbol')
            ->get();

        return view('investments.index', compact('portfolio', 'investments'));
    }

    public function create(Portfolio $portfolio): View
    {
        return view('investments.create', compact('portfolio'));
    }

    public function store(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $validated = $request->validate([
            'symbol' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:stock,crypto,bond,etf,mutual_fund,other',
            'current_price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
        ]);

        $validated['current_value'] = $validated['current_price'] * $validated['quantity'];
        $validated['total_invested'] = $validated['current_price'] * $validated['quantity'];
        $validated['profit_loss'] = 0;
        $validated['profit_loss_percentage'] = 0;

        $investment = $portfolio->investments()->create($validated);

        return redirect()->route('portfolios.investments.show', [$portfolio, $investment])
            ->with('success', 'Inversión creada exitosamente.');
    }

    public function show(Portfolio $portfolio, Investment $investment): View
    {
        $investment->load(['transactions' => function($query) {
            $query->orderByDesc('transaction_date');
        }]);

        return view('investments.show', compact('portfolio', 'investment'));
    }

    public function edit(Portfolio $portfolio, Investment $investment): View
    {
        return view('investments.edit', compact('portfolio', 'investment'));
    }

    public function update(Request $request, Portfolio $portfolio, Investment $investment): RedirectResponse
    {
        $validated = $request->validate([
            'symbol' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:stock,crypto,bond,etf,mutual_fund,other',
            'current_price' => 'required|numeric|min:0',
        ]);

        $oldValue = $investment->current_value;
        $newValue = $validated['current_price'] * $investment->quantity;

        $validated['current_value'] = $newValue;
        $validated['profit_loss'] = $newValue - $investment->total_invested;
        $validated['profit_loss_percentage'] = $investment->total_invested > 0
            ? (($newValue - $investment->total_invested) / $investment->total_invested) * 100
            : 0;

        $investment->update($validated);

        return redirect()->route('portfolios.investments.show', [$portfolio, $investment])
            ->with('success', 'Inversión actualizada exitosamente.');
    }

    public function destroy(Portfolio $portfolio, Investment $investment): RedirectResponse
    {
        $investment->delete();

        return redirect()->route('portfolios.investments.index', $portfolio)
            ->with('success', 'Inversión eliminada exitosamente.');
    }
}
