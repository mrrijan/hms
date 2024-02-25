<?php

namespace Api;

use Faker\Factory as Faker;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Room;

class RoomApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
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
        $rooms = Room::factory(10)->create();
        $roomIds = $rooms->map(fn($room) => $room->id);

        $response = $this->get('/api/rooms');

        $response->assertStatus(200);

        $data = $response->json('data');

        collect($data)->each(fn($room) => $this->assertTrue(in_array($room["id"], $roomIds->toArray())));
    }

    public function test_show_route()
    {
        $room = Room::factory(1)->create()[0];

        $response = $this->get('/api/room/' . $room->id);

        $result = $response->assertStatus(200)->json('data');

        $this->assertEquals(data_get($result, 'id'), $room->id);
    }

    public function test_post_route()
    {
        $faker = Faker::create();

        $room = [
            "room_number" => $faker->name,
            "maximum_occupancy" => $faker->numberBetween(2, 6),
            "occupancy_status" => $faker->boolean(),
            "number_of_beds" => $faker->numberBetween(1, 3)
        ];

        $response = $this->post('/api/room/create', $room);

        $response->assertStatus(201);

        $this->assertDatabaseHas('rooms', $room);
    }

    public function test_update_route()
    {
        $room = Room::factory(1)->create()[0];

        $updatedRoom = [
            "id" => $room->id,
            "room_number" => $room->room_number . "updated",
            "maximum_occupancy" => 3,
            "occupancy_status" => false,
            "number_of_beds" => 2
        ];

        $response = $this->post('/api/room/update', $updatedRoom);

        $response->assertStatus(201);

        $this->assertDatabaseHas('rooms', $updatedRoom);
    }

    public function test_delete_route()
    {
        $room = Room::factory(1)->create()[0];

        $response = $this->delete('/api/room/delete/' . $room->id);

        $response->assertStatus(201);

        $this->assertDatabaseMissing('rooms', $room->toArray());
    }
}
