<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $portfolio = $request->route('portfolio');
            if ($portfolio->user_id !== auth()->id()) {
                abort(403, 'No tienes permiso para acceder a este portafolio.');
            }

            $investment = $request->route('investment');
            if ($investment && $investment->portfolio_id !== $portfolio->id) {
                abort(403, 'Esta inversión no pertenece al portafolio especificado.');
            }

            return $next($request);
        });
    }

    public function index(Portfolio $portfolio, Investment $investment): View
    {
        $transactions = $investment->transactions()
            ->orderByDesc('transaction_date')
            ->get();

        return view('transactions.index', compact('portfolio', 'investment', 'transactions'));
    }

    public function create(Portfolio $portfolio, Investment $investment): View
    {
        return view('transactions.create', compact('portfolio', 'investment'));
    }

    public function store(Request $request, Portfolio $portfolio, Investment $investment): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:buy,sell',
            'quantity' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Calcular el monto total
        $validated['total_amount'] = $validated['quantity'] * $validated['price'];

        // Crear la transacción
        $transaction = $investment->transactions()->create($validated);

        // Actualizar la inversión
        $this->updateInvestmentAfterTransaction($investment, $transaction);

        return redirect()->route('portfolios.investments.transactions.index', [$portfolio, $investment])
            ->with('success', 'Transacción registrada exitosamente.');
    }

    public function edit(Portfolio $portfolio, Investment $investment, Transaction $transaction): View
    {
        return view('transactions.edit', compact('portfolio', 'investment', 'transaction'));
    }

    public function update(Request $request, Portfolio $portfolio, Investment $investment, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:buy,sell',
            'quantity' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Revertir los efectos de la transacción anterior
        $this->revertTransaction($investment, $transaction);

        // Actualizar la transacción
        $validated['total_amount'] = $validated['quantity'] * $validated['price'];
        $transaction->update($validated);

        // Recalcular los totales de la inversión
        $this->recalculateInvestmentTotals($investment);

        return redirect()->route('portfolios.investments.transactions.index', [$portfolio, $investment])
            ->with('success', 'Transacción actualizada exitosamente.');
    }

    public function destroy(Portfolio $portfolio, Investment $investment, Transaction $transaction): RedirectResponse
    {
        // Revertir los efectos de la transacción
        $this->revertTransaction($investment, $transaction);

        // Eliminar la transacción
        $transaction->delete();

        // Recalcular los totales de la inversión
        $this->recalculateInvestmentTotals($investment);

        return redirect()->route('portfolios.investments.transactions.index', [$portfolio, $investment])
            ->with('success', 'Transacción eliminada exitosamente.');
    }

    private function updateInvestmentAfterTransaction(Investment $investment, Transaction $transaction): void
    {
        if ($transaction->type === 'buy') {
            $investment->quantity += $transaction->quantity;
            $investment->total_invested += $transaction->total_amount;
        } else {
            $investment->quantity -= $transaction->quantity;
            // Para ventas, mantenemos el total_invested proporcional
            if ($investment->quantity > 0) {
                $investment->total_invested = ($investment->total_invested * ($investment->quantity / ($investment->quantity + $transaction->quantity)));
            } else {
                $investment->total_invested = 0;
            }
        }

        $investment->current_value = $investment->current_price * $investment->quantity;
        $investment->profit_loss = $investment->current_value - $investment->total_invested;
        $investment->profit_loss_percentage = $investment->total_invested > 0
            ? ($investment->profit_loss / $investment->total_invested) * 100
            : 0;

        $investment->save();
    }

    private function revertTransaction(Investment $investment, Transaction $transaction): void
    {
        if ($transaction->type === 'buy') {
            $investment->quantity -= $transaction->quantity;
            $investment->total_invested -= $transaction->total_amount;
        } else {
            $investment->quantity += $transaction->quantity;
            // Para ventas revertidas, restauramos el total_invested proporcional
            $oldQuantity = $investment->quantity - $transaction->quantity;
            if ($oldQuantity > 0) {
                $investment->total_invested = ($investment->total_invested * $investment->quantity) / $oldQuantity;
            }
        }

        $investment->save();
    }

    private function recalculateInvestmentTotals(Investment $investment): void
    {
        $investment->refresh();

        // Recalcular total_invested y cantidad desde las transacciones
        $totals = $investment->transactions()
            ->selectRaw('
                SUM(CASE WHEN type = "buy" THEN quantity ELSE -quantity END) as net_quantity,
                SUM(CASE WHEN type = "buy" THEN total_amount ELSE 0 END) as total_bought,
                SUM(CASE WHEN type = "sell" THEN total_amount ELSE 0 END) as total_sold
            ')
            ->first();

        $investment->quantity = max(0, $totals->net_quantity ?? 0);
        $investment->total_invested = max(0, $totals->total_bought ?? 0);

        if ($investment->quantity > 0) {
            // Ajustar el total_invested proporcionalmente si hay ventas
            $totalTransactions = $totals->total_bought + $totals->total_sold;
            if ($totalTransactions > 0) {
                $investment->total_invested = $investment->total_invested * ($investment->quantity / ($totals->net_quantity + $totals->total_sold / ($totals->total_bought / $totals->net_quantity)));
            }
        } else {
            $investment->total_invested = 0;
        }

        $investment->current_value = $investment->current_price * $investment->quantity;
        $investment->profit_loss = $investment->current_value - $investment->total_invested;
        $investment->profit_loss_percentage = $investment->total_invested > 0
            ? ($investment->profit_loss / $investment->total_invested) * 100
            : 0;

        $investment->save();
    }
}
