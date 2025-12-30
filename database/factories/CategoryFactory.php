<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Electronics',
                'Fashion',
                'Home & Living',
                'Groceries',
                'Health & Beauty',
                'Mobile Accessories',
                'Books & Stationery',
                'Sports & Outdoors'
            ]),
            'user_id' => 1, // Will be overridden in seeder
        ];
    }
}
