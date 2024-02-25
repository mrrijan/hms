<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "customer_id" => $this->faker->numberBetween(1, 10),
            "total_amount" => $this->faker->numberBetween(5000, 10000),
            "advance_payment" => $this->faker->numberBetween(1000, 3000),
            "payment_type" => $this->faker->name,
            "bill_no" => $this->faker->sentence,
        ];
    }
}
