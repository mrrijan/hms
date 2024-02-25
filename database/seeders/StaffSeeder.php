<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["Rijan","Chef","morning",9865174070],
            ["John", "Waiter", "evening", 9876543210],
            ["Emily", "Bartender", "night", 9654321870],
            ["Michael", "Sous Chef", "morning", 9765432101],
            ["Jessica", "Hostess", "evening", 9543210987],
            ["Daniel", "Line Cook", "night", 9432109876],
            ["Sarah", "Server", "morning", 9321098765],
            ["Christopher", "Dishwasher", "evening", 9210987654],
            ["Jennifer", "Manager", "night", 9109876543]
        ];
        foreach ($data as $datum)
        {
            $staff = new Staff();
            $staff->name = $datum[0];
            $staff->role = $datum[1];
            $staff->shift = $datum[2];
            $staff->phone = $datum[3];
            $staff->save();
        }
    }
}
