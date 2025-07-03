<?php

namespace Database\Factories;

use App\Models\PetImage;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PetImage>
 */
class PetImageFactory extends Factory
{
    protected $model = PetImage::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pet_id' => Pet::factory(),
            'image_path' => fake()->imageUrl(640, 480, 'animals', true, 'Pet Image'),
            'caption' => fake()->optional()->sentence(),
        ];
    }
}
