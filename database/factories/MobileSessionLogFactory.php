<?php

namespace Database\Factories;

use App\Models\MobileSessionLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<MobileSessionLog> */
class MobileSessionLogFactory extends Factory
{
    public function definition(): array
    {
        return ['collector_id' => User::factory(), 'device_id' => $this->faker->uuid(), 'device_name' => 'Android', 'logged_in_at' => now(), 'expires_at' => now()->addHours(12)];
    }
}
