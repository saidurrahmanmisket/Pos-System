<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total' => $this->faker->numberBetween(100, 10000),
            'discount' => $this->faker->numberBetween(0, 50),
            'vat' => 5,
            'payable' => $this->faker->numberBetween(100, 10000),
            'user_id' => 1, // Will be overridden
            'customer_id' => 1, // Will be overridden
            'created_at' => $this->faker->dateTimeBetween('-4 months', 'now'),
        ];
    }
}
