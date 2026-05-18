<?php

namespace Database\Factories;

use App\Models\VisitorLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<VisitorLog> */
class VisitorLogFactory extends Factory
{
    public function definition(): array
    {
        return ['visitor_name' => $this->faker->name(), 'visitor_phone' => $this->faker->phoneNumber(), 'purpose' => 'Visit', 'entered_at' => now()];
    }
}
