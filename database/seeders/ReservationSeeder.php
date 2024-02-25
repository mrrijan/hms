<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [1,1,"2024-08-19","2024-08-20"],
            [2, 6, "2024-08-20", "2024-08-21"],
            [3, 3, "2024-08-21", "2024-08-22"],
            [4, 8, "2024-08-22", "2024-08-23"],
        ];

    }
}
