<?php

namespace Tests\Unit;

use Faker\Factory as Faker;
use App\Services\RoomService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Room;

class RoomRepositoryTest extends TestCase
{

    use RefreshDatabase;

    public function test_get_all_rooms()
    {
        $rooms = Room::factory(3)->create();
        $roomIds = $rooms->map(fn($room) => $room->id);

        $roomService = $this->app->make(RoomService::class);

        $response = $roomService->getALlRooms([], 3);
        collect($response->toArray()["data"])->each(fn($room) => $this->assertTrue(in_array($room['id'], $roomIds->toArray())));
    }

    public function test_get_room_list()
    {
        $rooms = Room::factory(10)->create();

        $roomService = $this->app->make(RoomService::class);

        $response = $roomService->getRoomsList();

        $this->assertDatabaseHas('rooms', ["id" => $response->toArray()[0]["id"]]);
    }

    public function test_show()
    {
        $room = Room::factory(1)->create()[0];

        $roomService = $this->app->make(RoomService::class);

        $response = $roomService->showRoomById($room->id);

        $this->assertSame($room->id, $response->toArray()["id"], "Id do not match");
    }

    public function test_create()
    {
        $room = $this->app->make(RoomService::class);

        $faker = Faker::create();
        $payload = [
            "room_number" => $faker->name,
            "maximum_occupancy" => $faker->numberBetween(2, 5),
            "occupancy_status" => $faker->boolean,
            "number_of_beds" => $faker->numberBetween(1, 3)
        ];

        $room->createRoom($payload);

        $this->assertDatabaseHas('rooms', $payload);
    }

    public function test_update()
    {
        $room = $this->app->make(RoomService::class);

        $fakeRoom = Room::factory(1)->create()[0];

        $updatedRoom = [
            "id" => $fakeRoom->id,
            "room_number" => "aaa",
            "maximum_occupancy" => 3,
            "occupancy_status" => false,
            "number_of_beds" => 2
        ];

        $room->updateRoom($updatedRoom);

        $this->assertDatabaseHas('rooms', $updatedRoom);
    }

    public function test_delete()
    {
        $room = $this->app->make(RoomService::class);

        $fakeRoom = Room::factory(1)->create()[0];

        $room->deleteRoom($fakeRoom->id);

        $this->assertDatabaseMissing('rooms', $fakeRoom->toArray());
    }
}
