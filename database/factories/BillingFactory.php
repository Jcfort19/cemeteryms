<?php

namespace Database\Factories;

use App\Models\Billing;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Billing> */
class BillingFactory extends Factory
{
    public function definition(): array
    {
        $amount = $this->faker->numberBetween(5000, 50000);

        return [
            'client_id' => Client::factory(),
            'billing_number' => 'BIL-'.$this->faker->unique()->numerify('########'),
            'type' => 'lot',
            'description' => $this->faker->sentence(),
            'amount' => $amount,
            'paid_amount' => 0,
            'balance' => $amount,
            'due_date' => now()->addMonth(),
            'status' => 'pending',
        ];
    }
}
