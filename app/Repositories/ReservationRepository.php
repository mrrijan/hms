<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\Reservation;
use App\Repositories\Interfaces\ReservationRepositoryInterface;


class ReservationRepository extends BaseRepository implements ReservationRepositoryInterface
{
    public function __construct(Reservation $model)
    {
        parent::__construct($model);
    }

    public function getAllReservations($request, $paginator)
    {
        return $this->model
            ->when(@$request['search_term'], function ($q) use ($request) {
                $q->where('room_id', 'LIKE', "%{$request['search_term']}%")
                    ->orWhereHas('room', fn($q) => $q->where('room_number', 'LIKE', "%{$request['search_term']}%"))
                    ->orWhereHas('customer', fn($q) => $q->where('name', 'LIKE', "%{$request['search_term']}%"))
                    //->orWhere('identifier', 'LIKE', "%{$request['search_term']}%")
                    ->orWhere('check_in_date', 'LIKE', "%{$request['search_term']}%")
                    ->orWhere('check_out_date', 'LIKE', "%{$request['search_term']}%");
            })
            ->with(['room' => fn($q) => $q->select(['id', 'room_number'])])
            ->with(['customer' => fn($q) => $q->select(['id', 'name'])])
            ->latest()->paginate($paginator);
    }

}
