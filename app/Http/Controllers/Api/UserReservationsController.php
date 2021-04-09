<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReservationCollection;

class UserReservationsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $reservations = $user
            ->reservations()
            ->search($search)
            ->latest()
            ->paginate();

        return new ReservationCollection($reservations);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Reservation::class);

        $validated = $request->validate([
            'date' => ['required', 'date', 'date'],
            'begin_at' => ['required', 'date_format:H:i:s'],
            'end_at' => ['required', 'date_format:H:i:s'],
            'description' => ['nullable', 'max:255', 'string'],
            'room_id' => ['required', 'exists:rooms,id'],
        ]);

        $reservation = $user->reservations()->create($validated);

        return new ReservationResource($reservation);
    }
}
