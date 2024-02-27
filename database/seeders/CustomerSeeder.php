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
            ["Rijan Lama", 20, "Hetauda-4", "cz_2050-2", 9865174070],
            ["John Doe", 25, "New York-3", "abc_1234-1", 9876543210],
            ["Jane Smith", 30, "Los Angeles-6", "def_5678-3", 9654321870],
            ["Michael Johnson", 28, "Chicago-9", "ghi_9101-4", 9765432101],
            ["Emily Davis", 22, "Houston-12", "jkl_1121-5", 9543210987],
            ["Robert Williams", 35, "Philadelphia-15", "mno_3141-6", 9432109876],
            ["Jessica Brown", 18, "Phoenix-18", "pqr_4152-7", 9321098765],
            ["Daniel Wilson", 26, "San Antonio-21", "stu_6173-8", 9210987654],
            ["Sarah Garcia", 29, "San Diego-24", "vwx_8194-9", 9109876543],
            ["Christopher Martinez", 32, "Dallas-27", "yza_9205-0", 9876543210],
            ["David Johnson", 27, "Seattle-30", "bcd_0123-1", 9654321098],
            ["Jennifer Smith", 33, "Boston-33", "efg_2345-2", 9432108765],
            ["Kevin Brown", 24, "Miami-36", "hij_4567-3", 9321097654],
            ["Amanda Wilson", 28, "Atlanta-39", "klm_6789-4", 9210986543],
            ["Matthew Garcia", 31, "Denver-42", "nop_8901-5", 9109875432],
            ["Laura Martinez", 26, "Portland-45", "qrs_2345-6", 9876543210],
            ["Brandon Davis", 29, "Orlando-48", "tuv_4567-7", 9654321098],
            ["Stephanie Miller", 35, "Las Vegas-51", "wxy_6789-8", 9432108765],
            ["Justin White", 22, "San Francisco-54", "zab_8901-9", 9321097654],
            ["Melissa Taylor", 30, "Houston-57", "cde_0123-0", 9210986543]
        ];
        foreach ($data as $datum) {
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
