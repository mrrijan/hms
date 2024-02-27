<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\StaffSearchRequest;
use App\Http\Requests\StaffStoreRequest;
use App\Http\Requests\StaffUpdateRequest;
use App\Http\Resources\StaffsResource;
use App\Models\Staff;
use App\Services\StaffService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\Messages;

class StaffController extends Controller
{
    use Messages;

    /**
     * Display a listing of the resource.
     */
    public function index(StaffService $staffService, StaffSearchRequest $request)
    {
        $staffs = $staffService->getAllStaffs($request, 10);
        return StaffsResource::collection($staffs);
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
    public function store(StaffService $staffService, StaffStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $staffService->createStaff($request);
            DB::commit();
            [$msg, $stc] = array($this->getSuccessMessage('Staff'), Response::HTTP_CREATED);
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
    public function show(StaffService $staffService, $staff_id)
    {
        $staff = $staffService->showStaffById($staff_id);
        return new StaffsResource($staff);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StaffService $staffService, StaffUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $staffService->updateStaff($request);
            DB::commit();
            [$msg, $stc] = array($this->getUpdateMessage('Staff'), Response::HTTP_CREATED);
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
    public function destroy(StaffService $staffService, $staff_id)
    {
        try {
            DB::beginTransaction();
            $staffService->deleteStaff($staff_id);
            DB::commit();
            [$msg, $stc] = array($this->getDestroyMessage('Staff'), Response::HTTP_CREATED);
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
