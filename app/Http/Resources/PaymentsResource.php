<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "customer_id" =>$this->customer_id,
            "customer_name" => $this->customer->name,
            "total_amount" => $this->total_amount,
            "advance_payment" => $this->advance_payment,
            "payment_type" => $this->payment_type,
            "bill_no" => $this->bill_no
        ];
    }
}
