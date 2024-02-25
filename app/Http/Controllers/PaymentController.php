<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\PaymentSearchRequest;
use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaymentUpdateRequest;
use App\Http\Resources\PaymentsResource;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\Messages;

class PaymentController extends Controller
{
    use Messages;

    /**
     * Display a listing of the resource.
     */
    public function index(PaymentSearchRequest $request, PaymentService $paymentService)
    {
        $payments = $paymentService->getAllPayments($request, 7);
        return PaymentsResource::collection($payments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentStoreRequest $request, PaymentService $paymentService)
    {
        try {
            DB::beginTransaction();
            $paymentService->createPayment($request);
            DB::commit();
            [$msg, $stc] = array($this->getSuccessMessage('Payment'), Response::HTTP_CREATED);
        } catch (CustomException $e) {
            DB::rollBack();
            [$msg, $stc] = array($this->getErrorMessage($e->getMessage()), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exp) {
            DB::rollBack();
            Log::alert($exp->getMessage());
            [$msg, $stc] = array($this->getErrorMessage("Something Went wrong"), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json($msg, $stc);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentService $paymentService, $payment_id)
    {
        $payment = $paymentService->showPaymentById($payment_id);
        return new PaymentsResource($payment);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentUpdateRequest $request, PaymentService $paymentService)
    {
        try {
            DB::beginTransaction();
            $paymentService->updatePayment($request);
            DB::commit();
            [$msg, $stc] = array($this->getUpdateMessage('Payment'), Response::HTTP_CREATED);
        } catch (CustomException $e) {
            DB::rollBack();
            [$msg, $stc] = array($this->getErrorMessage($e->getMessage()), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exp) {
            DB::rollBack();
            Log::alert($exp->getMessage());
            [$msg, $stc] = array($this->getErrorMessage('Something Went wrong'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json($msg, $stc);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentService $paymentService, $payment_id)
    {
        try {
            DB::beginTransaction();
            $paymentService->deletePayment($payment_id);
            DB::commit();
            [$msg, $stc] = array($this->getDestroyMessage('Payment'), Response::HTTP_CREATED);
        } catch (CustomException $e) {
            DB::rollBack();
            [$msg, $stc] = array($this->getErrorMessage($e->getMessage()), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $exp) {
            DB::rollBack();
            Log::alert($exp->getMessage());
            [$msg, $stc] = array($this->getErrorMessage('Something Went wrong'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json($msg, $stc);
    }
}
