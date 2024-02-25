<?php

namespace Api;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Staff;
use Faker\Factory as Faker;
use App\Models\User;

class StaffApiTest extends TestCase
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
        $staffs = Staff::factory(10)->create();
        $staffIds = $staffs->map(fn($staff) => $staff->id);

        $response = $this->get('/api/staffs');
        $response->assertStatus(200);

        $data = $response->json('data');

        collect($data)->each(fn($staff) => $this->assertTrue(in_array($staff['id'], $staffIds->toArray())));
    }

    public function test_show_route()
    {
        $staff = Staff::factory(1)->create()[0];

        $response = $this->get('/api/staff/' . $staff->id);

        $response->assertStatus(200);

        $result = $response->json('data');

        $this->assertEquals(data_get($result, 'id'), $staff->id);
    }

    public function test_post_route()
    {
        $faker = Faker::create();

        $staff = [
            "name" => $faker->name,
            "role" => $faker->sentence,
            "shift" => $faker->text,
            "phone" => $faker->numerify("9845025865")
        ];

        $response = $this->post('/api/staff/create', $staff);

        $response->assertStatus(201);

        $this->assertDatabaseHas('staff', $staff);
    }

    public function test_update_route()
    {
        $staff = Staff::factory(1)->create()[0];

        $updatedStaff = [
            "id" => $staff->id,
            "name" => $staff->name . "updated",
            "role" => $staff->role . "updated",
            "shift" => $staff->shift . "updated",
            "phone" => $staff->phone
        ];

        $response = $this->post('/api/staff/update', $updatedStaff);

        $response->assertStatus(201);
        $this->assertDatabaseHas('staff', $updatedStaff);
    }

    public function test_delete_route()
    {
        $staff = Staff::factory(1)->create()[0];

        $response = $this->delete('/api/staff/delete/' . $staff->id);

        $response->assertStatus(201);

        $this->assertDatabaseMissing('staff', $staff->toArray());
    }
    
}
