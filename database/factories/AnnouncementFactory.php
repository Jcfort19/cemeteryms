<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Announcement> */
class AnnouncementFactory extends Factory
{
    public function definition(): array
    {
        return ['title' => $this->faker->sentence(4), 'body' => $this->faker->paragraph(), 'audience' => 'public', 'published_at' => now()];
    }
}
