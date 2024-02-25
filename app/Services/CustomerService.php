<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerService
{
    public function __construct(private readonly CustomerRepositoryInterface $customerRepository)
    {

    }

    public function getAllCustomers($request, $paginator)
    {
        return $this->customerRepository->getAllCustomers($request, $paginator);
    }

    public function createCustomer($request)
    {
        $data = [
            "name" => $request['name'],
            "age" => $request['age'],
            "address" => $request['address'],
            "citizenship_no" => $request['citizenship_no'],
            "phone_no" => $request['phone_no']
        ];
        $data = $this->customerRepository->create($data);
        if (!$data) throw new CustomException('Cannot create Customer');
    }

    public function updateCustomer($request)
    {
        $data = [
            "name" => $request['name'],
            "age" => $request['age'],
            "address" => $request['address'],
            "citizenship_no" => $request['citizenship_no'],
            "phone_no" => $request['phone_no']
        ];
        $data = $this->customerRepository->update($request['id'], $data);
        if (!$data) throw new CustomException('Customer could not be updated');
    }

    public function showCustomerById($customer_id)
    {
        return $this->customerRepository->findById($customer_id);
    }

    public function deleteCustomer($customer_id)
    {
        return $this->customerRepository->destroy($customer_id);
    }

    public function getCustomersList()
    {
        return $this->customerRepository->getCustomersList();
    }
}
