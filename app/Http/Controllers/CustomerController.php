<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\CustomerSearchRequest;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Resources\CustomersListResource;
use App\Http\Resources\CustomersResource;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use App\Traits\Messages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    use Messages;

    public function index(CustomerService $customerService, CustomerSearchRequest $request)
    {
        $customers = $customerService->getAllCustomers($request, 10);
        return CustomersResource::collection($customers);
    }

    public function store(CustomerStoreRequest $request, CustomerService $customerService)
    {
        try {
            DB::beginTransaction();
            $customerService->createCustomer($request);
            DB::commit();
            [$msg, $stc] = array($this->getSuccessMessage('Customer'), Response::HTTP_CREATED);
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

    public function update(CustomerService $customerService, CustomerUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $customerService->updateCustomer($request);
            DB::commit();
            [$msg, $stc] = array($this->getUpdateMessage('Customer'), Response::HTTP_CREATED);
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

    public function show(CustomerService $customerService, $customer_id)
    {
        $customer = $customerService->showCustomerById($customer_id);
        return new CustomersResource($customer);
    }

    public function destroy(CustomerService $customerService, $customer_id)
    {
        try {
            DB::beginTransaction();
            $customerService->deleteCustomer($customer_id);
            DB::commit();
            [$msg, $stc] = array($this->getDestroyMessage('Customer'), Response::HTTP_CREATED);
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

    public function getCustomersList(CustomerService $customerService)
    {
        $customers = $customerService->getCustomersList();
        return CustomersListResource::collection($customers);
    }
}
