<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//login
Route::post('/login', [AuthenticationController::class, 'login']);
Route::middleware(['auth:sanctum'])->get('/logout', [AuthenticationController::class, 'logout']);

//user
Route::middleware(['auth:sanctum'])->get('/users', [UserController::class, 'index']);

//customer
Route::middleware(['auth:sanctum'])->get('/customers', [CustomerController::class, 'index']);
Route::middleware(['auth:sanctum'])->post('/customer/create', [CustomerController::class, 'store']);
Route::middleware(['auth:sanctum'])->post('/customer/update', [CustomerController::class, 'update']);
Route::middleware(['auth:sanctum'])->get('/customer/{customer_id}', [CustomerController::class, 'show']);
Route::middleware(['auth:sanctum'])->delete('/customer/delete/{customer_id}', [CustomerController::class, 'destroy']);
Route::middleware(['auth:sanctum'])->get('/customersList', [CustomerController::class, 'getCustomersList']); //for reservation

//Room
Route::middleware(['auth:sanctum'])->get('/rooms', [RoomController::class, 'index']);
Route::middleware(['auth:sanctum'])->post('/room/create', [RoomController::class, 'store']);
Route::middleware(['auth:sanctum'])->post('/room/update', [RoomController::class, 'update']);
Route::middleware(['auth:sanctum'])->get('/room/{room_id}', [RoomController::class, 'show']);
Route::middleware(['auth:sanctum'])->delete('/room/delete/{room_id}', [RoomController::class, 'destroy']);
Route::middleware(['auth:sanctum'])->get('/roomsList', [RoomController::class, 'getRoomsList']); //for reservation
Route::middleware(['auth:sanctum'])->get('/vacantRoomsList', [RoomController::class, 'getVacantRoomsList']); //for reservation

//staff
Route::middleware(['auth:sanctum'])->get('/staffs', [StaffController::class, 'index']);
Route::middleware(['auth:sanctum'])->post('/staff/create', [StaffController::class, 'store']);
Route::middleware(['auth:sanctum'])->post('/staff/update', [StaffController::class, 'update']);
Route::middleware(['auth:sanctum'])->get('/staff/{staff_id}', [StaffController::class, 'show']);
Route::middleware(['auth:sanctum'])->delete('/staff/delete/{staff_id}', [StaffController::class, 'destroy']);

//reservation
Route::middleware(['auth:sanctum'])->get('/reservations', [ReservationController::class, 'index']);
Route::middleware(['auth:sanctum'])->post('/reservation/create', [ReservationController::class, 'store']);
Route::middleware(['auth:sanctum'])->get('/reservation/{reservation_id}', [ReservationController::class, 'show']);
Route::middleware(['auth:sanctum'])->post('/reservation/update', [ReservationController::class, 'update']);
Route::middleware(['auth:sanctum'])->delete('/reservation/delete/{reservation_id}', [ReservationController::class, 'destroy']);

//Payment
Route::middleware(['auth:sanctum'])->get('/payments', [PaymentController::class, 'index']);
Route::middleware(['auth:sanctum'])->post('/payment/create', [PaymentController::class, 'store']);
Route::middleware(['auth:sanctum'])->post('/payment/update', [PaymentController::class, 'update']);
Route::middleware(['auth:sanctum'])->get('/payment/{payment_id}', [PaymentController::class, 'show']);
Route::middleware(['auth:sanctum'])->delete('/payment/delete/{payment_id}', [PaymentController::class, 'destroy']);
