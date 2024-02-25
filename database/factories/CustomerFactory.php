<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "age" => $this->faker->numberBetween(18,25),
            "address" => $this->faker->sentence,
            "citizenship_no" => $this->faker->sentence,
            "phone_no" => $this->faker->numerify('9845025865'),
        ];
    }
}
