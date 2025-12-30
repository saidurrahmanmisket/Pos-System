<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            'Miniket Rice (5kg)' => 'rice',
            'Rupchanda Soybean Oil (5L)' => 'oil',
            'ACI Pure Salt (1kg)' => 'salt',
            'Radhuni Turmeric Powder' => 'turmeric',
            'Pran Potato Crackers' => 'chips',
            'Ispahani Mirzapore Tea' => 'tea',
            'Bashundhara Tissue Box' => 'tissue',
            'Lux Soap' => 'soap',
            'Sunsilk Shampoo' => 'shampoo',
            'Lifebuoy Hand Wash' => 'handwash',
            'Dano Milk Powder' => 'milk',
            'Maggi Noodles (Pack of 8)' => 'noodles',
            'Aarong Dairy Ghee' => 'ghee',
            'Deshi Lentils (Moshur Dal)' => 'lentils',
            'Teer Sugar (1kg)' => 'sugar',
        ];

        $name = $this->faker->randomElement(array_keys($products));
        $keyword = $products[$name];

        return [
            'user_id' => 1, // Will be overridden
            'category_id' => 1, // Will be overridden
            'name' => $name,
            'price' => $this->faker->randomFloat(2, 50, 2000), // Adjusted price range for BD context
            'unit' => $this->faker->randomElement(['kg', 'pcs', 'L', 'pack', 'box']),
            'img_url' => "https://loremflickr.com/600/400/{$keyword}?lock=" . $this->faker->randomNumber(5),
            // Added lock param to ensure consistent but different images per call if needed, or just random
        ];
    }
}
