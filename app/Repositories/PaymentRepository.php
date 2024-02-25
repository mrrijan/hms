<?php

namespace App\Repositories;

use App\Exceptions\CustomException;
use App\Models\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;


class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

    public function getAllPayments($request, $paginator)
    {
        return $this->model
            ->when(@$request['search_term'], function ($q) use ($request) {
                $q->where('payment_type', 'LIKE', "%{$request['search_term']}%")
                    ->orWhereHas('customer', fn($q) => $q->where('name', 'LIKE', "%{$request['search_term']}%"))
                    ->orWhere('bill_no', 'LIKE', "%{$request['search_term']}%");
            })
            ->with(["customer" => fn($q) => $q->select(["id", "name"])])
            ->latest()->paginate($paginator);
    }
}
