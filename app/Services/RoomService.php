<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Repositories\Interfaces\RoomRepositoryInterface;

class RoomService
{
    public function __construct(private readonly RoomRepositoryInterface $roomRepository)
    {

    }

    public function getALlRooms($request, $paginator)
    {
        return $this->roomRepository->getAllRooms($request, $paginator);
    }

    public function createRoom($request)
    {
        $data = [
            "room_number" => $request['room_number'],
            "maximum_occupancy" => $request['maximum_occupancy'],
            "occupancy_status" => $request['occupancy_status'],
            "number_of_beds" => $request['number_of_beds']
        ];
        $data = $this->roomRepository->create($data);
        if (!$data) throw new CustomException('Room could not be created');
    }

    public function updateRoom($request)
    {
        $data = [
            "room_number" => $request['room_number'],
            "maximum_occupancy" => $request['maximum_occupancy'],
            "occupancy_status" => $request['occupancy_status'],
            "number_of_beds" => $request['number_of_beds']
        ];
        $data = $this->roomRepository->update($request['id'], $data);
        if (!$data) throw new CustomException('Room could not be updated');
    }

    public function showRoomById($room_id)
    {
        return $this->roomRepository->findById($room_id);
    }

    public function deleteRoom($room_id)
    {
        return $this->roomRepository->destroy($room_id);
    }

    public function getRoomsList()
    {
        return $this->roomRepository->getRoomsList();
    }

    public function getVacantRoomsList()
    {
        return $this->roomRepository->getVacantRoomsList();
    }

    public function changeRoomOccupancyStatus($room_id, $occupancy_status)
    {
        $data = [
            "occupancy_status" => $occupancy_status
        ];
        $data = $this->roomRepository->update($room_id, $data);
    }
}
