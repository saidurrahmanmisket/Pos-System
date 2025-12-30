<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
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
                'Rahim Uddin',
                'Karim Mia',
                'Abdul Alim',
                'Sultana Razia',
                'Fatema Begum',
                'Md. Jamal Hossain',
                'Nasrin Akter',
                'Kamal Hasan',
                'Ayesha Siddiqua',
                'Rafiqul Islam'
            ]),
            'email' => $this->faker->unique()->safeEmail(),
            'mobile' => '01' . $this->faker->numberBetween(3, 9) . $this->faker->numerify('########'), // 017xxxxxxxx format
            'user_id' => 1, // Will be overridden in seeder
        ];
    }
}
