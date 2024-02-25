<?php

namespace Api;

use App\Models\Payment;
use App\Models\User;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;

class PaymentApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
        $user = User::where('email', 'lamarijan@gmail.com')->first();
        $this->actingAs($user, 'web');
    }

    public function test_get_route()
    {
        $this->seed(CustomerSeeder::class);
        $payments = Payment::factory(10)->create();
        $paymentIds = $payments->map(fn($payment) => $payment->id);

        $response = $this->get('/api/payments');
        $response->assertStatus(200);

        $data = $response->json('data');
        collect($data)->each(fn($payment) => $this->assertTrue(in_array($payment["id"], $paymentIds->toArray())));
    }

    public function test_show_route()
    {
        $this->seed(CustomerSeeder::class);
        $payment = Payment::factory(1)->create()[0];
        $response = $this->get('/api/payment/' . $payment->id);
        $result = $response->assertStatus(200)->json('data');
        $this->assertEquals(data_get($result, 'id'), $payment->id);
    }

    public function test_post_route()
    {
        $this->seed(CustomerSeeder::class);
        $faker = Faker::create();
        $payment = [
            "customer_id" => $faker->numberBetween(1, 10),
            "total_amount" => $faker->numberBetween(5000, 10000),
            "advance_payment" => $faker->numberBetween(1000, 3000),
            "payment_type" => $faker->name,
            "bill_no" => $faker->sentence,
        ];
        $response = $this->post('/api/payment/create', $payment);
        $response->assertStatus(201);

        $this->assertDatabaseHas('payments', $payment);
    }

    public function test_update_route()
    {
        $this->seed(CustomerSeeder::class);
        $payment = Payment::factory(1)->create()[0];

        $paymentUpdated = [
            "id" => $payment->id,
            "customer_id" => 5,
            "total_amount" => 6000,
            "advance_payment" => 1000,
            "payment_type" => $payment->name . "updated",
            "bill_no" => $payment->bill_no . "updated",
        ];

        $response = $this->post('/api/payment/update', $paymentUpdated);
        $response->assertStatus(201);
        $this->assertDatabaseHas('payments', $paymentUpdated);
    }

    public function test_delete_route()
    {
        $payment = Payment::factory(1)->create()[0];

        $response = $this->delete('/api/payment/delete/' . $payment->id);
        $response->assertStatus(201);

        $this->assertDatabaseMissing('payments', $payment->toArray());
    }
}
