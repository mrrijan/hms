<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "age" => $this->age,
            "address" => $this->address,
            "citizenship_no" => $this->citizenship_no,
            "phone_no" => $this->phone_no
        ];
    }
}
