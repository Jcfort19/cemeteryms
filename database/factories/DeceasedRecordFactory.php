<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\DeceasedRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<DeceasedRecord> */
class DeceasedRecordFactory extends Factory
{
    public function definition(): array
    {
        return ['client_id' => Client::factory(), 'first_name' => $this->faker->firstName(), 'last_name' => $this->faker->lastName(), 'birth_date' => now()->subYears(70), 'death_date' => now()->subYear(), 'interment_date' => now()->subMonths(11), 'privacy' => 'family'];
    }
}
