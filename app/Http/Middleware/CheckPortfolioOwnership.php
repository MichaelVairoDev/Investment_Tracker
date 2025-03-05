<?php

namespace App\Http\Middleware;

use App\Models\Portfolio;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPortfolioOwnership
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($portfolio = $request->route('portfolio')) {
            if (!$portfolio instanceof Portfolio) {
                $portfolio = Portfolio::findOrFail($portfolio);
            }

            if ($portfolio->user_id !== auth()->id()) {
                abort(403, 'No tienes permiso para acceder a este portafolio.');
            }
        }

        return $next($request);
    }
}
