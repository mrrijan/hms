<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentService
{
    public function __construct(private readonly PaymentRepositoryInterface $paymentRepository)
    {

    }

    public function getAllPayments($request, $paginator)
    {
        return $this->paymentRepository->getAllPayments($request, $paginator);
    }

    public function createPayment($request)
    {
        $data = [
            "customer_id" => $request['customer_id'],
            "total_amount" => $request['total_amount'],
            "advance_payment" => $request['advance_payment'],
            "payment_type" => $request['payment_type'],
            "bill_no" => $request['bill_no'],
        ];
        $data = $this->paymentRepository->create($data);
        if (!$data) throw new CustomException("cannot create payment");
    }

    public function updatePayment($request)
    {
        $data = [
            "customer_id" => $request['customer_id'],
            "total_amount" => $request['total_amount'],
            "advance_payment" => $request['advance_payment'],
            "payment_type" => $request['payment_type'],
            "bill_no" => $request['bill_no'],
        ];
        $data = $this->paymentRepository->update($request['id'], $data);
        if (!$data) throw new CustomException("Cannot update payment");
    }

    public function showPaymentById($payment_id)
    {
        return $this->paymentRepository->findById($payment_id);
    }

    public function deletePayment($payment_id)
    {
        return $this->paymentRepository->destroy($payment_id);
    }

}
