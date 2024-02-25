<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "room_id" => $this->faker->numberBetween(1, 10),
            "customer_id" => $this->faker->numberBetween(1, 10),
            "check_in_date" => $this->faker->date('Y-m-d'),
            "check_out_date" => $this->faker->date('Y-m-d')
        ];
    }
}
