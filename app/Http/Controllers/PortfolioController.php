<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $portfolios = auth()->user()->portfolios()
            ->withCount('investments')
            ->withSum('investments', 'current_value')
            ->withSum('investments', 'total_invested')
            ->latest()
            ->get();

        return view('portfolios.index', compact('portfolios'));
    }

    public function create(): View
    {
        return view('portfolios.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $portfolio = auth()->user()->portfolios()->create($validated);

        return redirect()->route('portfolios.show', $portfolio)
            ->with('success', 'Portafolio creado exitosamente.');
    }

    public function show(Portfolio $portfolio): View
    {
        $this->authorize('view', $portfolio);

        $portfolio->load(['investments' => function($query) {
            $query->withCount('transactions')
                  ->orderBy('symbol');
        }]);

        return view('portfolios.show', compact('portfolio'));
    }

    public function edit(Portfolio $portfolio): View
    {
        $this->authorize('update', $portfolio);
        return view('portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $this->authorize('update', $portfolio);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $portfolio->update($validated);

        return redirect()->route('portfolios.show', $portfolio)
            ->with('success', 'Portafolio actualizado exitosamente.');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $this->authorize('delete', $portfolio);

        $portfolio->delete();

        return redirect()->route('portfolios.index')
            ->with('success', 'Portafolio eliminado exitosamente.');
    }
}
