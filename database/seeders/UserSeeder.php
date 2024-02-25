<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["Rijan Lama" ,"lamarijan@gmail.com" , "password"],
            ["Ram" ,"user1@gmail.com" ,"password"],
            ["Hari" , "user2@gmail.com","password"]
        ];
        foreach ($data as $datum)
        {
            $user = new User();
            $user->name = $datum[0];
            $user->email = $datum[1];
            $user->password = Hash::make($datum[2]);
            $user->save();
        }
    }
}
