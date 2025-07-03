<?php

namespace Database\Factories;

use App\Models\PetImage;
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
        $units = ['weeks', 'months', 'years'];
        return [
            'name' => fake()->firstName(),
            'species' => fake()->randomElement(['Dog', 'Cat', 'Bird', 'Fish']),
            'breed' => fake()->word(),
            'age' => fake()->numberBetween(1, 12) . ' ' . fake()->randomElement($units),
            'gender' => fake()->randomElement(['male', 'female', 'unknown']),
            'status' => fake()->randomElement(['available', 'adopted']),
            'description' => fake()->paragraph(),
            'user_id' => User::factory()->lister(),
            'vaccinated' => fake()->boolean(),
            'vaccination_details' => fake()->optional()->sentence(),
            'special_needs' => fake()->optional()->sentence(),
            'location' => fake()->city(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function ($pet) {
            PetImage::factory()
                ->count(fake()->numberBetween(1, 5))
                ->create([
                    'pet_id' => $pet->id
                ]);
        });
    }
}
