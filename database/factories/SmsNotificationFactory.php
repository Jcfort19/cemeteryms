<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\SmsNotification;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SmsNotification> */
class SmsNotificationFactory extends Factory
{
    public function definition(): array
    {
        return ['client_id' => Client::factory(), 'recipient' => '09171234567', 'type' => 'due_reminder', 'message' => $this->faker->sentence(), 'provider' => 'semaphore', 'status' => 'queued'];
    }
}
