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
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'price' => $this->faker->randomFloat(2, 15, 340.40),
            'description' => $this->faker->text(),
            'category' => $this->faker->randomElement(['eletronics', 'home', 'health', 'sports']), // Between elements
            'image_url' => $this->faker->imageUrl()
        ];
    }
}
