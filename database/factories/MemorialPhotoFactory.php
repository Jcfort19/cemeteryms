<?php

namespace Database\Factories;

use App\Models\MemorialPage;
use App\Models\MemorialPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<MemorialPhoto> */
class MemorialPhotoFactory extends Factory
{
    public function definition(): array
    {
        return ['memorial_page_id' => MemorialPage::factory(), 'path' => 'memorials/sample.jpg', 'caption' => $this->faker->sentence(3), 'sort_order' => 0];
    }
}
