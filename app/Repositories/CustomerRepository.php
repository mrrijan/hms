<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;


class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }
    public function getAllCustomers($request, $paginator)
    {
       return $this->model
           ->when(@$request['search_term'], function ($q) use ($request) {
               $q->where('name', 'LIKE', "%{$request['search_term']}%")
                   //->orWhere('identifier', 'LIKE', "%{$request['search_term']}%")
                   ->orWhere('address', 'LIKE', "%{$request['search_term']}%")
                   ->orWhere('phone_no', 'LIKE', "%{$request['search_term']}%")
                   ->orWhere('citizenship_no', 'LIKE', "%{$request['search_term']}%")
                   ->orWhere('age', 'LIKE', "%{$request['search_term']}%");
           })
           ->latest()->paginate($paginator);
    }

    public function getCustomersList()
    {
        return $this->model->all();
    }
}
