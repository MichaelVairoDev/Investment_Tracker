<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvestmentFactory extends Factory
{
    public function definition(): array
    {
        $quantity = $this->faker->randomFloat(6, 0.1, 1000);
        $price = $this->faker->randomFloat(2, 1, 1000);
        $total = $quantity * $price;
        $currentPrice = $price * (1 + $this->faker->randomFloat(2, -0.3, 0.5));
        $currentValue = $quantity * $currentPrice;
        $profitLoss = $currentValue - $total;
        $profitLossPercentage = ($profitLoss / $total) * 100;

        return [
            'symbol' => strtoupper($this->faker->lexify('???')),
            'name' => $this->faker->company(),
            'type' => $this->faker->randomElement(['stock', 'crypto', 'bond', 'etf', 'mutual_fund', 'other']),
            'current_price' => $currentPrice,
            'quantity' => $quantity,
            'total_invested' => $total,
            'current_value' => $currentValue,
            'profit_loss' => $profitLoss,
            'profit_loss_percentage' => $profitLossPercentage,
        ];
    }
}
