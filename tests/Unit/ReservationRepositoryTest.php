<?php

namespace Tests\Unit;

use App\Services\ReservationService;
use App\Services\RoomService;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\RoomSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Reservation;

class ReservationRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_reservations()
    {
        $reservations = Reservation::factory(1)->create()[0];

        $reservationService = $this->app->make(ReservationService::class);

        $response = $reservationService->getAllReservations([], 3);
        $this->assertSame($reservations->id, $response->toArray()["data"][0]["id"], "Id do not match");
    }

    public function test_create()
    {
        $this->seed(CustomerSeeder::class);
        $this->seed(RoomSeeder::class);
        $reservation = [
            "room_id" => 1,
            "customer_id" => 1,
            "check_in_date" => '2080-08-08',
            "check_out_date" => '2080-08-10'
        ];
        $reservationService = $this->app->make(ReservationService::class);
        $roomService = $this->app->make(RoomService::class);
        $reservationService->createReservation($reservation, $roomService);
        $this->assertDatabaseHas('reservations', $reservation);
    }

    public function test_update_when_room_is_changed()
    {
        $this->seed(CustomerSeeder::class);
        $this->seed(RoomSeeder::class);
        $reservation = Reservation::factory(1)->create()[0];
        $reservationService = $this->app->make(ReservationService::class);
        $roomService = $this->app->make(RoomService::class);
        $updatedReservation = [
            "id" => $reservation->id,
            "room_id" => 2,
            "room_id_previous" => 4,
            "customer_id" => 4,
            "check_in_date" => "2080-08-10",
            "check_out_date" => "2080-08-11",
        ];
        $reservationService->updateReservation($updatedReservation, $roomService);
        $this->assertDatabaseHas('reservations', ["check_in_date" => $updatedReservation["check_in_date"]]);
    }

    public function test_update_when_room_is_not_changed()
    {
        $this->seed(CustomerSeeder::class);
        $this->seed(RoomSeeder::class);
        $reservation = Reservation::factory(1)->create()[0];
        $reservationService = $this->app->make(ReservationService::class);
        $roomService = $this->app->make(RoomService::class);
        $updatedReservation = [
            "id" => $reservation->id,
            "room_id_previous" => 2,
            "customer_id" => 4,
            "check_in_date" => "2080-08-10",
            "check_out_date" => "2080-08-15",
        ];
        $reservationService->updateReservation($updatedReservation, $roomService);
        $this->assertDatabaseHas('reservations', ["check_out_date" => $updatedReservation["check_out_date"]]);
    }

    public function test_delete()
    {
        $reservation = Reservation::factory(1)->create()[0];

        $reservationService = $this->app->make(ReservationService::class);

        $reservationService->deleteReservation($reservation->id);

        $this->assertDatabaseMissing('reservations', $reservation->toArray());
    }
}
