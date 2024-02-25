<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Repositories\Interfaces\ReservationRepositoryInterface;

class ReservationService
{
    public function __construct(private readonly ReservationRepositoryInterface $reservationRepository)
    {

    }

    public function getAllReservations($request, $paginator)
    {
        return $this->reservationRepository->getAllReservations($request, $paginator);
    }

    public function createReservation($request, RoomService $roomService)
    {
        $data = [
            "room_id" => $request['room_id'],
            "customer_id" => $request['customer_id'],
            "check_in_date" => $request['check_in_date'],
            "check_out_date" => $request['check_out_date'],
        ];
        $data = $this->reservationRepository->create($data);
        $roomService->changeRoomOccupancyStatus($request['room_id']);
        if (!$data) throw new CustomException("Reservation Could Not Be Created");
    }

    public function getReservationById($reservation_id)
    {
        return $this->reservationRepository->findById($reservation_id);
    }

    public function updateReservation($request, RoomService $roomService)
    {
        $data = [
            "room_id" => $request['room_id'],
            "customer_id" => $request['customer_id'],
            "check_in_date" => $request['check_in_date'],
            "check_out_date" => $request['check_out_date'],
        ];
        $data = $this->reservationRepository->update($request['id'], $data);
        $roomService->changeRoomOccupancyStatus($request['room_id']);
        if (!$data) throw new CustomException("Reservation Could not be update");
    }

    public function deleteReservation($reservation_id)
    {
        return $this->reservationRepository->destroy($reservation_id);
    }
}
