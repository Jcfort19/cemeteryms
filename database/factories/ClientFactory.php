<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Client> */
class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_number' => 'CL-'.$this->faker->unique()->numerify('########'),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'qr_token' => $this->faker->unique()->sha256(),
            'qr_issued_at' => now(),
            'portal_enabled' => true,
            'status' => 'active',
        ];
    }
}
