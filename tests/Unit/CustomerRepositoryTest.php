<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use App\Models\Customer;
use Faker\Factory as Faker;
use App\Services\CustomerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     * //     */
//    public function test_example(): void
//    {
//        $this->assertTrue(true);
//    }

//how to get started
//1.Define the goal
//2.Replicate the env/restriction
//3.define the source of truth
//4.compare the result
    public function test_get_customers()
    {
        $customer = Customer::factory(1)->create()[0];

        $customerService = $this->app->make(CustomerService::class);

        $response = $customerService->getAllCustomers([], 3);

        $this->assertSame($customer->id, $response->toArray()["data"][0]["id"], "Id donot match");
    }

    public function test_show_customer_list()
    {
        $customers = Customer::factory(10)->create();

        $customerService = $this->app->make(CustomerService::class);

        $response = $customerService->getCustomersList();
        $this->assertDatabaseHas('customers', ["id" => $response->toArray()[0]["id"]]);
    }

    public function test_show()
    {
        $customer = Customer::factory(1)->create()[0];

        $customerService = $this->app->make(CustomerService::class);

        $response = $customerService->showCustomerById($customer->id);

        $this->assertSame($customer->id, $response->toArray()["id"], "Id do not match");
    }

    public function test_create()
    {
        //1.Define the goal
        //check if create() creates a record in DB

        //2.Replicate the env/restriction
        $customer = $this->app->make(CustomerService::class);

        //3.define the source of truth
        $payload = [
            'name' => "Hayley",
            'age' => 18,
            'address' => 'asdss',
            'citizenship_no' => 'asdasd',
            'phone_no' => 9854025865
        ];
        //4.compare the result
        $customer->createCustomer($payload);

        $result = Customer::where('name', 'Hayley')->first();

//        $this->assertSame($payload['name'],$result->name,'Post created doesnot have the same name');
//        $this->assertTrue(Customer::where('name','Hayley')->exists());
        $this->assertDatabaseHas('customers', $payload);
    }

    public function test_update()
    {
        $customer = $this->app->make(CustomerService::class);
        $faker = Faker::create();
        $fakeCustomer = Customer::factory(1)->create()[0];
//        dd($fakeCustomer);
        $payload = [
            'id' => $fakeCustomer->id,
            'name' => $faker->name() . 'updated',
            'age' => 20,
            'address' => 'new address',
            'citizenship_no' => 'new',
            'phone_no' => 9854479680,
        ];
        $customer->updateCustomer($payload);
//        $updated = Customer::where('name', $payload['name'])->first();
//        $this->assertSame($payload['name'],$updated->name,'Post updated doesnot have the same title');
        $this->assertDatabaseHas('customers', $payload);
    }

    public function test_delete()
    {
        $customer = $this->app->make(CustomerService::class);

        $fakerCustomer = Customer::factory(1)->create()[0];

        $customer->deleteCustomer($fakerCustomer->id);

        $result = Customer::where('id', $fakerCustomer->id)->exists();

        $this->assertFalse($result, 'Customer did not get deleted');
        //$this->assertTrue(Customer::where('id',$result->id)->exists());
        $this->assertDatabaseMissing('customers', $fakerCustomer->toArray());
    }
}
