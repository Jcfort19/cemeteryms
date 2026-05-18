<?php

namespace Database\Factories;

use App\Models\CemeteryLot;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Reservation> */
class ReservationFactory extends Factory
{
    public function definition(): array
    {
        return ['cemetery_lot_id' => CemeteryLot::factory(), 'reservation_number' => 'RES-'.$this->faker->unique()->numerify('########'), 'applicant_name' => $this->faker->name(), 'applicant_email' => $this->faker->safeEmail(), 'applicant_phone' => $this->faker->phoneNumber(), 'requirements' => ['valid_id' => 'uploaded'], 'scheduled_at' => now()->addWeek(), 'status' => 'pending'];
    }
}
