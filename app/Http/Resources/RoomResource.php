<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "room_number" => $this->room_number,
            "maximum_occupancy" => $this->maximum_occupancy,
            "occupancy_status" => $this->occupancy_status,
            "number_of_beds" => $this->number_of_beds
        ];
    }
}
