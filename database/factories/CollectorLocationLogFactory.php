<?php

namespace Database\Factories;

use App\Models\CollectorLocationLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<CollectorLocationLog> */
class CollectorLocationLogFactory extends Factory
{
    public function definition(): array
    {
        return ['collector_id' => User::factory(), 'latitude' => 8.165, 'longitude' => 125.990, 'accuracy' => 10, 'recorded_at' => now()];
    }
}
