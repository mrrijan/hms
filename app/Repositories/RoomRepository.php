<?php

namespace App\Repositories;

use App\Models\Room;
use App\Repositories\Interfaces\RoomRepositoryInterface;


class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    public function __construct(Room $model)
    {
        parent::__construct($model);
    }

    public function getAllRooms($request, $paginator)
    {
        return $this->model
            ->when(@$request['search_term'], function ($q) use ($request) {
                $q->where('room_number', 'LIKE', "%{$request['search_term']}%")
                    ->orWhere('maximum_occupancy', 'LIKE', "%{$request['search_term']}%")
                    ->orWhere('number_of_beds', 'LIKE', "%{$request['search_term']}%");
            })
            ->when(@$request['occupancy'], function ($q) use ($request) {
                if ($request['occupancy'] === "2") $request['occupancy'] = 0;
                $q->where('occupancy_status', 'LIKE', "%{$request['occupancy']}%");
            })
            ->latest()->paginate($paginator);
    }


    public function getRoomsList()
    {
        return $this->model->all();
    }

    public function getVacantRoomsList()
    {
        return $this->model->where('occupancy_status', 0)->get();
    }
}
