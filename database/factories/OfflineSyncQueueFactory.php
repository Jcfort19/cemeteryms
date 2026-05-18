<?php

namespace Database\Factories;

use App\Models\OfflineSyncQueue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<OfflineSyncQueue> */
class OfflineSyncQueueFactory extends Factory
{
    public function definition(): array
    {
        return ['collector_id' => User::factory(), 'device_id' => $this->faker->uuid(), 'local_uuid' => $this->faker->unique()->uuid(), 'type' => 'payment', 'payload' => ['amount' => 1000], 'status' => 'pending'];
    }
}
