<?php

namespace Tests\Unit;

use App\Models\Payment;
use App\Services\PaymentService;
use Database\Factories\PaymentFactory;
use Database\Seeders\CustomerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;

class PaymentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_payments()
    {
        $payment = Payment::factory(1)->create()[0];

        $paymentService = $this->app->make(PaymentService::class);

        $response = $paymentService->getAllPayments([], 3);
        $this->assertSame($payment->id, $response->toArray()["data"][0]["id"], "Id do not match");
    }

    public function test_create()
    {
        $this->seed(CustomerSeeder::class);
        $faker = Faker::create();
        $payment = [
            "customer_id" => $faker->numberBetween(1, 10),
            "total_amount" => $faker->numberBetween(5000, 10000),
            "advance_payment" => $faker->numberBetween(1000, 3000),
            "payment_type" => $faker->name,
            "bill_no" => $faker->sentence
        ];
        $paymentService = $this->app->make(PaymentService::class);
        $paymentService->createPayment($payment);
        $this->assertDatabaseHas('payments', $payment);
    }

    public function test_update()
    {
        $payment = Payment::factory(1)->create()[0];

        $paymentUpdated = [
            "id" => $payment->id,
            "customer_id" => 4,
            "total_amount" => 6000,
            "advance_payment" => 2000,
            "payment_type" => $payment->payment_type . "updated",
            "bill_no" => $payment->bill_no . "updated"
        ];

        $paymentService = $this->app->make(PaymentService::class);
        $paymentService->updatePayment($paymentUpdated);
        $this->assertDatabaseHas('payments', $paymentUpdated);
    }

    public function test_delete()
    {
        $payment = Payment::factory(1)->create()[0];

        $paymentService = $this->app->make(PaymentService::class);

        $paymentService->deletePayment($payment->id);

        $this->assertDatabaseMissing('payments', $payment->toArray());
    }
}
