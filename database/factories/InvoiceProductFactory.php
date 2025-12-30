<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceProduct>
 */
class InvoiceProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => 1, // Will be overridden
            'product_id' => 1, // Will be overridden
            'user_id' => 1, // Will be overridden
            'qty' => $this->faker->numberBetween(1, 10),
            'sale_price' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
