<?php

namespace App\Repositories\Interfaces;

interface ReservationRepositoryInterface
{
    public function getAllReservations($request, $paginator);

}
