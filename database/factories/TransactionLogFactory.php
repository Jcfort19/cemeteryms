<?php

namespace Database\Factories;

use App\Models\TransactionLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<TransactionLog> */
class TransactionLogFactory extends Factory
{
    public function definition(): array
    {
        return ['type' => 'payment.posted', 'reference' => 'PAY-'.$this->faker->numerify('########'), 'amount' => 1000, 'payload' => ['channel' => 'cashier']];
    }
}
