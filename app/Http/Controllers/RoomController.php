<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\RoomSearchRequest;
use App\Http\Requests\RoomStoreRequest;
use App\Http\Requests\RoomUpdateRequest;
use App\Http\Resources\RoomsListResource;
use App\Http\Resources\RoomsResource;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\Messages;

class RoomController extends Controller
{
    use Messages;

    /**
     * Display a listing of the resource.
     */
    public function index(RoomService $roomService, RoomSearchRequest $request)
    {
        $rooms = $roomService->getALlRooms($request, 7);
        return RoomsResource::collection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoomService $roomService, RoomStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $roomService->createRoom($request);
            DB::commit();
            [$msg, $stc] = array($this->getSuccessMessage('Room'), Response::HTTP_CREATED);
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
    public function show(RoomService $roomService, $room_id)
    {
        $room = $roomService->showRoomById($room_id);
        return new RoomsResource($room);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoomService $roomService, RoomUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            $roomService->updateRoom($request);
            DB::commit();
            [$msg, $stc] = array($this->getUpdateMessage('Room'), Response::HTTP_CREATED);
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
    public function destroy(RoomService $roomService, $room_id)
    {
        try {
            DB::beginTransaction();
            $roomService->deleteRoom($room_id);
            DB::commit();
            [$msg, $stc] = array($this->getDestroyMessage('Room'), Response::HTTP_CREATED);
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


    //for reservation roomList
    public function getRoomsList(RoomService $roomService)
    {
        $rooms = $roomService->getRoomsList();
        return RoomsListResource::collection($rooms);
    }

    public function getVacantRoomsList(RoomService $roomService)
    {
        $rooms = $roomService->getVacantRoomsList();
        return RoomsListResource::collection($rooms);
    }
}
