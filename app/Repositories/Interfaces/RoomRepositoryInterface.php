<?php

namespace App\Repositories\Interfaces;

interface RoomRepositoryInterface
{
    public function getAllRooms($request, $paginator);


    //for reservation roomslist
    public function getRoomsList();

    public function getVacantRoomsList();
}
