<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\CollectorAssignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<CollectorAssignment> */
class CollectorAssignmentFactory extends Factory
{
    public function definition(): array
    {
        return ['collector_id' => User::factory(), 'client_id' => Client::factory(), 'assigned_date' => today(), 'status' => 'assigned'];
    }
}
