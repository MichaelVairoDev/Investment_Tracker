<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $quantity = $this->faker->randomFloat(6, 0.1, 100);
        $price = $this->faker->randomFloat(2, 1, 1000);

        return [
            'type' => $this->faker->randomElement(['buy', 'sell']),
            'quantity' => $quantity,
            'price' => $price,
            'total_amount' => $quantity * $price,
            'notes' => $this->faker->optional()->sentence(),
            'transaction_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
