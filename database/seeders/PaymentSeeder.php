<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [1, 5000, 2500, "bank", "sn_123"],
            [2, 6000, 3000, "credit card", "sn_124"],
            [3, 4500, 2000, "cash", "sn_125"],
            [4, 7000, 3500, "paypal", "sn_126"],
            [5, 5500, 2750, "bank", "sn_127"],
            [6, 8000, 4000, "credit card", "sn_128"],
            [7, 4000, 1800, "cash", "sn_129"],
            [8, 6500, 3250, "paypal", "sn_130"],
            [9, 7500, 3750, "bank", "sn_131"],
            [10, 5200, 2600, "credit card", "sn_132"],
            [11, 5300, 2650, "bank", "sn_133"],
            [12, 6200, 3100, "credit card", "sn_134"],
            [13, 4700, 2350, "cash", "sn_135"],
            [14, 7100, 3550, "paypal", "sn_136"],
            [15, 5600, 2800, "bank", "sn_137"],
            [16, 8100, 4050, "credit card", "sn_138"],
            [17, 4100, 2050, "cash", "sn_139"],
            [18, 6600, 3300, "paypal", "sn_140"],
            [19, 7600, 3800, "bank", "sn_141"],
            [20, 5300, 2650, "credit card", "sn_142"]
        ];
        foreach ($data as $datum) {
            $payment = new Payment();
            $payment->customer_id = $datum[0];
            $payment->total_amount = $datum[1];
            $payment->advance_payment = $datum[2];
            $payment->payment_type = $datum[3];
            $payment->bill_no = $datum[4];
            $payment->save();
        }
    }
}
