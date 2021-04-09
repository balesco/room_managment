<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomReservationsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_room_reservations()
    {
        $room = Room::factory()->create();
        $reservations = Reservation::factory()
            ->count(2)
            ->create([
                'room_id' => $room->id,
            ]);

        $response = $this->getJson(
            route('api.rooms.reservations.index', $room)
        );

        $response->assertOk()->assertSee($reservations[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_room_reservations()
    {
        $room = Room::factory()->create();
        $data = Reservation::factory()
            ->make([
                'room_id' => $room->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.rooms.reservations.store', $room),
            $data
        );

        $this->assertDatabaseHas('reservations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $reservation = Reservation::latest('id')->first();

        $this->assertEquals($room->id, $reservation->room_id);
    }
}
