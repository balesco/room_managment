<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReservationCollection;

class RoomReservationsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Room $room)
    {
        $this->authorize('view', $room);

        $search = $request->get('search', '');

        $reservations = $room
            ->reservations()
            ->search($search)
            ->latest()
            ->paginate();

        return new ReservationCollection($reservations);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Room $room)
    {
        $this->authorize('create', Reservation::class);

        $validated = $request->validate([
            'date' => ['required', 'date', 'date'],
            'begin_at' => ['required', 'date_format:H:i:s'],
            'end_at' => ['required', 'date_format:H:i:s'],
            'description' => ['nullable', 'max:255', 'string'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $reservation = $room->reservations()->create($validated);

        return new ReservationResource($reservation);
    }
}
