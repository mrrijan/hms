<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "room_number" => $this->faker->name,
            "maximum_occupancy" => $this->faker->numberBetween(2, 6),
            "occupancy_status" => $this->faker->boolean(),
            "number_of_beds" => $this->faker->numberBetween(1, 3)
        ];
    }
}
