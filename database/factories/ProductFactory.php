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
        return [
            'user_id' => 1, // Will be overridden
            'category_id' => 1, // Will be overridden
            'name' => $this->faker->randomElement([
                'Miniket Rice (5kg)',
                'Rupchanda Soybean Oil (5L)',
                'ACI Pure Salt (1kg)',
                'Radhuni Turmeric Powder',
                'Pran Potato Crackers',
                'Ispahani Mirzapore Tea',
                'Bashundhara Tissue Box',
                'Lux Soap',
                'Sunsilk Shampoo',
                'Lifebuoy Hand Wash',
                'Dano Milk Powder',
                'Maggi Noodles (Pack of 8)',
                'Aarong Dairy Ghee',
                'Deshi Lentils (Moshur Dal)',
                'Teer Sugar (1kg)'
            ]),
            'price' => $this->faker->randomFloat(2, 50, 2000), // Adjusted price range for BD context
            'unit' => $this->faker->randomElement(['kg', 'pcs', 'L', 'pack', 'box']),
            'img_url' => 'https://placehold.co/600x400/EEE/31343C',
        ];
    }
}
