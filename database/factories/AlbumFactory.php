<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Photographer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'photographer_id' => Photographer::factory(),
        ];
    }
}
