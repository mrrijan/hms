<?php

namespace App\Repositories;

use App\Models\Staff;
use App\Repositories\Interfaces\StaffRepositoryInterface;


class StaffRepository extends BaseRepository implements StaffRepositoryInterface
{
    public function __construct(Staff $model)
    {
        parent::__construct($model);
    }
    public function getAllStaffs($request,$paginator)
    {
        return $this->model
            ->when(@$request['search_term'], function ($q) use ($request) {
            $q->where('name', 'LIKE', "%{$request['search_term']}%")
                //->orWhere('identifier', 'LIKE', "%{$request['search_term']}%")
                ->orWhere('role', 'LIKE', "%{$request['search_term']}%")
                ->orWhere('shift', 'LIKE', "%{$request['search_term']}%")
                ->orWhere('phone', 'LIKE', "%{$request['search_term']}%");
        })->latest()->paginate($paginator);
    }
}
