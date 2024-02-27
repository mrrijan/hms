<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["23A", 2, false, 1],
            ["24B", 4, false, 2],
            ["12C", 3, false, 1],
            ["15D", 5, false, 3],
            ["10E", 2, false, 1],
            ["21F", 6, false, 4],
            ["18G", 3, false, 2],
            ["9H", 2, false, 1],
            ["16I", 4, false, 2],
            ["22J", 3, false, 1],
            ["19K", 5, false, 3],
            ["25L", 4, false, 2],
            ["26M", 3, false, 1],
            ["27N", 2, false, 1],
            ["28O", 5, false, 3],
            ["29P", 6, false, 4],
            ["30Q", 3, false, 2],
            ["31R", 2, false, 1],
            ["32S", 4, false, 2],
            ["33T", 5, false, 3],
            ["34U", 2, false, 1]
        ];
        foreach ($data as $datum) {
            $room = new Room();
            $room->room_number = $datum[0];
            $room->maximum_occupancy = $datum[1];
            $room->occupancy_status = $datum[2];
            $room->number_of_beds = $datum[3];
            $room->save();
        }
    }
}
