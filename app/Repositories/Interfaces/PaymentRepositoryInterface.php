<?php

namespace App\Repositories\Interfaces;

interface PaymentRepositoryInterface
{
    public function getAllPayments($request, $paginator);

}
