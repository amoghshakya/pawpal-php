<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'species' => fake()->randomElement(['Dog', 'Cat', 'Bird', 'Fish']),
            'breed' => fake()->word(),
            'age' => fake()->numberBetween(1, 15),
            'gender' => fake()->randomElement(['male', 'female', 'unknown']),
            'status' => fake()->randomElement(['available', 'adopted']),
            'description' => fake()->paragraph(),
            'user_id' => User::factory()->lister(),
        ];
    }
}
