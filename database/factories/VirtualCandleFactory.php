<?php

namespace Database\Factories;

use App\Models\MemorialPage;
use App\Models\VirtualCandle;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<VirtualCandle> */
class VirtualCandleFactory extends Factory
{
    public function definition(): array
    {
        return ['memorial_page_id' => MemorialPage::factory(), 'visitor_name' => $this->faker->firstName(), 'visitor_ip' => '127.0.0.1', 'lit_at' => now()];
    }
}
