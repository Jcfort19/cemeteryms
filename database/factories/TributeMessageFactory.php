<?php

namespace Database\Factories;

use App\Models\MemorialPage;
use App\Models\TributeMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<TributeMessage> */
class TributeMessageFactory extends Factory
{
    public function definition(): array
    {
        return ['memorial_page_id' => MemorialPage::factory(), 'author_name' => $this->faker->name(), 'author_email' => $this->faker->safeEmail(), 'message' => $this->faker->paragraph(), 'status' => 'pending'];
    }
}
