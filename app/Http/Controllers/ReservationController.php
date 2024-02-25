<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\ReservationSearchRequest;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\ReservationUpdateRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReservationsResource;
use App\Models\Reservation;
use App\Services\ReservationService;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\Messages;

class ReservationController extends Controller
{
    use Messages;

    /**
     * Display a listing of the resource.
     */
    public function index(ReservationService $reservationService, ReservationSearchRequest $request)
    {
        $reservations = $reservationService->getAllReservations($request, 7);
        return ReservationsResource::collection($reservations);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationStoreRequest $request, ReservationService $reservationService, RoomService $roomService)
    {
        try {
            DB::beginTransaction();
            $reservationService->createReservation($request, $roomService);
            DB::commit();
            [$msg, $stc] = array($this->getSuccessMessage('Reservation'), Response::HTTP_CREATED);
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
    public function show(ReservationService $reservationService, $reservation_id)
    {
        $reservation = $reservationService->getReservationById($reservation_id);
        return new ReservationResource($reservation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationUpdateRequest $request, ReservationService $reservationService, RoomService $roomService)
    {
        try {
            DB::beginTransaction();
            $reservationService->updateReservation($request, $roomService);
            DB::commit();
            [$msg, $stc] = array($this->getUpdateMessage('Reservation'), Response::HTTP_CREATED);
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
    public function destroy(ReservationService $reservationService, $reservation_id)
    {
        try {
            DB::beginTransaction();
            $reservationService->deleteReservation($reservation_id);
            DB::commit();
            [$msg, $stc] = array($this->getDestroyMessage('Reservation'), Response::HTTP_CREATED);
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
