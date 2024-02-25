<?php

namespace App\Repositories\Interfaces;

interface CustomerRepositoryInterface
{
    public function getAllCustomers($request,$paginator);

    public function getCustomersList();

}
