<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Room;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomTest extends TestCase
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
    public function it_gets_rooms_list()
    {
        $rooms = Room::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.rooms.index'));

        $response->assertOk()->assertSee($rooms[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_room()
    {
        $data = Room::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.rooms.store'), $data);

        $this->assertDatabaseHas('rooms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_room()
    {
        $room = Room::factory()->create();

        $data = [
            'name' => $this->faker->text(255),
        ];

        $response = $this->putJson(route('api.rooms.update', $room), $data);

        $data['id'] = $room->id;

        $this->assertDatabaseHas('rooms', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_room()
    {
        $room = Room::factory()->create();

        $response = $this->deleteJson(route('api.rooms.destroy', $room));

        $this->assertDeleted($room);

        $response->assertNoContent();
    }
}
