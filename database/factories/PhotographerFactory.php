<?php

namespace Database\Factories;

use App\Models\Photographer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Photographer>
 */
class PhotographerFactory extends Factory
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
            'instagram' => $this->faker->userName(),
        ];
    }
}
