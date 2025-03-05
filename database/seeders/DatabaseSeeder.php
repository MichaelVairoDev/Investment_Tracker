<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Portfolio;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario demo
        $user = User::create([
            'name' => 'Usuario Demo',
            'email' => 'demo@example.com',
            'password' => Hash::make('demo1234'),
            'email_verified_at' => now(),
        ]);

        // Portafolio 1: Acciones Tech
        $techPortfolio = Portfolio::create([
            'user_id' => $user->id,
            'name' => 'Portafolio Tech',
            'description' => 'Inversiones en empresas tecnológicas',
        ]);

        // Inversiones en Tech
        $this->createInvestment($techPortfolio, 'AAPL', 'Apple Inc.', 'stock', 170.50);
        $this->createInvestment($techPortfolio, 'MSFT', 'Microsoft Corporation', 'stock', 380.20);
        $this->createInvestment($techPortfolio, 'GOOGL', 'Alphabet Inc.', 'stock', 140.50);

        // Portafolio 2: Criptomonedas
        $cryptoPortfolio = Portfolio::create([
            'user_id' => $user->id,
            'name' => 'Criptomonedas',
            'description' => 'Inversiones en criptomonedas',
        ]);

        // Inversiones en Crypto
        $this->createInvestment($cryptoPortfolio, 'BTC', 'Bitcoin', 'crypto', 42000.00);
        $this->createInvestment($cryptoPortfolio, 'ETH', 'Ethereum', 'crypto', 2200.00);
        $this->createInvestment($cryptoPortfolio, 'SOL', 'Solana', 'crypto', 110.00);

        // Portafolio 3: ETFs
        $etfPortfolio = Portfolio::create([
            'user_id' => $user->id,
            'name' => 'ETFs Globales',
            'description' => 'Inversiones en ETFs diversificados',
        ]);

        // Inversiones en ETFs
        $this->createInvestment($etfPortfolio, 'VTI', 'Vanguard Total Stock Market ETF', 'etf', 240.30);
        $this->createInvestment($etfPortfolio, 'VOO', 'Vanguard S&P 500 ETF', 'etf', 410.80);
        $this->createInvestment($etfPortfolio, 'QQQ', 'Invesco QQQ Trust', 'etf', 385.60);

        // Portafolio 4: Bonos
        $bondsPortfolio = Portfolio::create([
            'user_id' => $user->id,
            'name' => 'Renta Fija',
            'description' => 'Inversiones en bonos y renta fija',
        ]);

        // Inversiones en Bonos
        $this->createInvestment($bondsPortfolio, 'TLT', 'iShares 20+ Year Treasury Bond ETF', 'bond', 95.40);
        $this->createInvestment($bondsPortfolio, 'AGG', 'iShares Core U.S. Aggregate Bond ETF', 'bond', 98.20);
        $this->createInvestment($bondsPortfolio, 'BND', 'Vanguard Total Bond Market ETF', 'bond', 72.50);

        // Portafolio 5: Fondos Mutuos
        $mutualPortfolio = Portfolio::create([
            'user_id' => $user->id,
            'name' => 'Fondos Mutuos',
            'description' => 'Inversiones en fondos mutuos',
        ]);

        // Inversiones en Fondos Mutuos
        $this->createInvestment($mutualPortfolio, 'FXAIX', 'Fidelity 500 Index Fund', 'mutual_fund', 158.90);
        $this->createInvestment($mutualPortfolio, 'VFIAX', 'Vanguard 500 Index Fund', 'mutual_fund', 378.40);
        $this->createInvestment($mutualPortfolio, 'FCNTX', 'Fidelity Contrafund', 'mutual_fund', 14.80);
    }

    private function createInvestment($portfolio, $symbol, $name, $type, $currentPrice)
    {
        $investment = Investment::create([
            'portfolio_id' => $portfolio->id,
            'symbol' => $symbol,
            'name' => $name,
            'type' => $type,
            'current_price' => $currentPrice,
            'quantity' => 0,
            'current_value' => 0,
            'total_invested' => 0,
            'profit_loss' => 0,
            'profit_loss_percentage' => 0,
        ]);

        // Crear transacciones de compra en diferentes momentos
        $dates = [
            now()->subMonths(12),
            now()->subMonths(9),
            now()->subMonths(6),
            now()->subMonths(3),
            now()->subMonths(1),
        ];

        $totalQuantity = 0;
        $totalInvested = 0;

        foreach ($dates as $index => $date) {
            $price = $currentPrice * (1 + rand(-20, 20) / 100); // Precio histórico aleatorio ±20%
            $quantity = rand(1, 10) + (rand(0, 100) / 100); // Cantidad entre 1 y 10 con decimales

            if ($index === 4 && rand(0, 1)) { // 50% de probabilidad de que la última transacción sea una venta
                $sellQuantity = $totalQuantity * (rand(20, 50) / 100); // Vender entre 20% y 50% de la posición
                Transaction::create([
                    'investment_id' => $investment->id,
                    'type' => 'sell',
                    'quantity' => $sellQuantity,
                    'price' => $price,
                    'total_amount' => $sellQuantity * $price,
                    'transaction_date' => $date,
                    'notes' => 'Venta parcial de posición',
                ]);
                $totalQuantity -= $sellQuantity;
            } else {
                Transaction::create([
                    'investment_id' => $investment->id,
                    'type' => 'buy',
                    'quantity' => $quantity,
                    'price' => $price,
                    'total_amount' => $quantity * $price,
                    'transaction_date' => $date,
                    'notes' => 'Compra programada',
                ]);
                $totalQuantity += $quantity;
                $totalInvested += $quantity * $price;
            }
        }

        // Actualizar la inversión con los totales
        $currentValue = $totalQuantity * $currentPrice;
        $profitLoss = $currentValue - $totalInvested;
        $profitLossPercentage = $totalInvested > 0 ? ($profitLoss / $totalInvested) * 100 : 0;

        $investment->update([
            'quantity' => $totalQuantity,
            'current_value' => $currentValue,
            'total_invested' => $totalInvested,
            'profit_loss' => $profitLoss,
            'profit_loss_percentage' => $profitLossPercentage,
        ]);
    }
}
