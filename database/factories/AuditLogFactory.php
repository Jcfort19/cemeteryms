<?php

namespace Database\Factories;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<AuditLog> */
class AuditLogFactory extends Factory
{
    public function definition(): array
    {
        return ['action' => 'created', 'new_values' => ['sample' => true], 'ip_address' => '127.0.0.1'];
    }
}
