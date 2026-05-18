<?php

namespace Database\Factories;

use App\Models\Billing;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Payment> */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'billing_id' => Billing::factory(),
            'client_id' => Client::factory(),
            'reference_number' => 'PAY-'.$this->faker->unique()->numerify('########'),
            'amount' => $this->faker->numberBetween(500, 10000),
            'payment_type' => 'cash',
            'channel' => 'cashier',
            'status' => 'posted',
            'paid_at' => now(),
        ];
    }
}
