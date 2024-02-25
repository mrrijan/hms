<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Repositories\Interfaces\StaffRepositoryInterface;

class StaffService
{
    public function __construct(private readonly StaffRepositoryInterface $staffRepository)
    {

    }
    public function getAllStaffs($request,$paginator)
    {
        return $this->staffRepository->getAllStaffs($request,$paginator);
    }

    public function createStaff($request)
    {
        $data = [
            'name' => $request['name'],
            'role' => $request['role'],
            'shift' => $request['shift'],
            'phone' => $request['phone']
        ];
        $data = $this->staffRepository->create($data);
        if(!$data) throw new CustomException('Staff could not be created');
    }

    public function updateStaff($request)
    {
        $data = [
            'name' => $request['name'],
            'role' => $request['role'],
            'shift' => $request['shift'],
            'phone' => $request['phone']
        ];
        $data = $this->staffRepository->update($request['id'],$data);
        if(!$data) throw new CustomException('Staff Could not be updated');
    }

    public function showStaffById($staff_id)
    {
        return $this->staffRepository->findById($staff_id);
    }

    public function deleteStaff($staff_id)
    {
        return $this->staffRepository->destroy($staff_id);
    }
}
