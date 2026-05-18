<?php

namespace Database\Factories;

use App\Models\CemeteryLot;
use App\Models\CemeterySection;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<CemeteryLot> */
class CemeteryLotFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cemetery_section_id' => CemeterySection::factory(),
            'lot_number' => $this->faker->unique()->bothify('L-###'),
            'block' => $this->faker->randomLetter(),
            'area_sqm' => 6.25,
            'price' => 35000,
            'status' => $this->faker->randomElement(['vacant', 'reserved', 'occupied']),
            'polygon' => [[8.165, 125.990], [8.1651, 125.9901], [8.1652, 125.990]],
        ];
    }
}
