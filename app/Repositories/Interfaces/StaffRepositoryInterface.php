<?php

namespace App\Repositories\Interfaces;

interface StaffRepositoryInterface
{
    public function getAllStaffs($request,$paginator);
}
