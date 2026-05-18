<?php

namespace Database\Factories;

use App\Models\DeceasedRecord;
use App\Models\MemorialPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<MemorialPage> */
class MemorialPageFactory extends Factory
{
    public function definition(): array
    {
        return ['deceased_record_id' => DeceasedRecord::factory(), 'slug' => $this->faker->unique()->slug(), 'title' => 'In Memory of '.$this->faker->name(), 'biography' => $this->faker->paragraph(), 'privacy' => 'family', 'is_published' => true, 'published_at' => now()];
    }
}
