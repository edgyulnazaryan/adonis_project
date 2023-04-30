<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsProduct>
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
            'name' => fake()->word,
            'price' => fake()->numberBetween(100, 1000),
            'quantity' => fake()->numberBetween(1, 100),
            'status' => fake()->randomElement(['active', 'inactive']),
            'image' => fake()->imageUrl(),
        ];
    }
}
