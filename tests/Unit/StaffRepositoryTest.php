<?php

namespace Tests\Unit;

use App\Models\Staff;
use App\Services\StaffService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;

class StaffRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_staffs()
    {
        $staff = Staff::factory(1)->create()[0];
        $staffService = $this->app->make(StaffService::class);

        $response = $staffService->getAllStaffs([], 3);

        $this->assertSame($staff->id, $response->toArray()["data"][0]["id"], "Id do not match");
    }

    public function test_show()
    {
        $staff = Staff::factory(1)->create()[0];

        $staffService = $this->app->make(StaffService::class);

        $response = $staffService->showStaffById($staff->id);

        $this->assertSame($staff->id, $response->toArray()["id"], "Id do not match");
    }

    public function test_create()
    {
        $faker = Faker::create();
        $payload = [
            "name" => $faker->name,
            "role" => $faker->text,
            "shift" => $faker->sentence,
            "phone" => $faker->numerify('9845025865')
        ];
        $staffService = $this->app->make(StaffService::class);

        $staffService->createStaff($payload);

        $this->assertDatabaseHas('staff', $payload);
    }

    public function test_update()
    {
        $staff = Staff::factory(1)->create()[0];

        $staffService = $this->app->make(StaffService::class);

        $staffUpdated = [
            "id" => $staff->id,
            "name" => $staff->name . "updated",
            "role" => $staff->role . "updated",
            "shift" => $staff->shift . "updated",
            "phone" => 1234567890,
        ];

        $staffService->updateStaff($staffUpdated);

        $this->assertDatabaseHas('staff', $staffUpdated);
    }

    public function tests_delete()
    {
        $staff = Staff::factory(1)->create()[0];

        $staffService = $this->app->make(StaffService::class);

        $staffService->deleteStaff($staff->id);

        $this->assertDatabaseMissing('staff', $staff->toArray());
    }
}
