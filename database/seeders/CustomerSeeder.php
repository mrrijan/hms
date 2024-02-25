<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["Rijan Lama",20,"Hetauda-4","cz_2050-2",9865174070],
            ["John Doe", 25, "New York-3", "abc_1234-1", 9876543210],
            ["Jane Smith", 30, "Los Angeles-6", "def_5678-3", 9654321870],
            ["Michael Johnson", 28, "Chicago-9", "ghi_9101-4", 9765432101],
            ["Emily Davis", 22, "Houston-12", "jkl_1121-5", 9543210987],
            ["Robert Williams", 35, "Philadelphia-15", "mno_3141-6", 9432109876],
            ["Jessica Brown", 18, "Phoenix-18", "pqr_4152-7", 9321098765],
            ["Daniel Wilson", 26, "San Antonio-21", "stu_6173-8", 9210987654],
            ["Sarah Garcia", 29, "San Diego-24", "vwx_8194-9", 9109876543],
            ["Christopher Martinez", 32, "Dallas-27", "yza_9205-0", 9876543210]
        ];
        foreach ($data as $datum)
        {
            $customer = new Customer();
            $customer->name = $datum[0];
            $customer->age = $datum[1];
            $customer->address = $datum[2];
            $customer->citizenship_no = $datum[3];
            $customer->phone_no = $datum[4];
            $customer->save();
        }
    }
}
