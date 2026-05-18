<?php

namespace Database\Factories;

use App\Models\CemeterySection;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<CemeterySection> */
class CemeterySectionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('S##'),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'boundary_polygon' => [[8.165, 125.990], [8.166, 125.990], [8.166, 125.991]],
            'color' => '#4A5C6A',
            'is_active' => true,
        ];
    }
}
