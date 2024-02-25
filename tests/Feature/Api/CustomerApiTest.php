<?php

namespace Api;

use App\Models\Customer;
use Faker\Factory as Faker;
use App\Models\User;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        //$this->seed(CustomerSeeder::class);
        $this->seed(UserSeeder::class);

        $user = User::where('email', 'lamarijan@gmail.com')->first();
        $this->actingAs($user, 'web');
    }

    public function test_customers_get_route(): void
    {
        $customers = Customer::factory(10)->create();
        $customerIds = $customers->map(fn($customer) => $customer->id);

        $response = $this->get('/api/customers');
        $response->assertStatus(200);

        $data = $response->json('data');
        collect($data)->each(fn($customer) => $this->assertTrue(in_array($customer['id'], $customerIds->toArray())));
    }

    public function test_customer_show_route()
    {
//        $this->seed(CustomerSeeder::class);
        $customer = Customer::factory(1)->create()[0];

        $response = $this->get('/api/customer/' . $customer->id);

        $result = $response->assertStatus(200)->json('data');

        $this->assertEquals(data_get($result, 'id'), $customer->id, 'Id does not match');
    }

    public function test_customers_create_route()
    {
        $faker = Faker::create();
        $customer = [
            "name" => $faker->name,
            "age" => $faker->numberBetween(17, 20),
            "address" => $faker->address,
            "citizenship_no" => $faker->sentence(),
            "phone_no" => $faker->numerify('9854025865')
        ];

        $response = $this->post('/api/customer/create', $customer);

        $response->assertStatus(201);

        $this->assertDatabaseHas('customers', $customer);
    }

    public function test_customers_update_route()
    {
        $customer = Customer::factory(1)->create()[0];

        $faker = Faker::create();

        $payload = [
            "id" => $customer->id,
            "name" => $faker->name . 'updated',
            "age" => 21,
            "address" => "asssddd",
            "citizenship_no" => "qewqesad",
            "phone_no" => 9845025865,
        ];

        $response = $this->post('/api/customer/update', $payload);

        $response->assertStatus(201);
    }

    public function test_customers_delete_route()
    {
        $fakerCustomer = Customer::factory(1)->create()[0];

        $response = $this->delete('/api/customer/delete/' . $fakerCustomer->id);
        $response->assertStatus(201);
    }
}
