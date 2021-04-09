<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReservationCollection;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\ReservationUpdateRequest;

class ReservationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Reservation::class);

        $search = $request->get('search', '');

        $reservations = Reservation::search($search)
            ->latest()
            ->paginate();

        return new ReservationCollection($reservations);
    }

    /**
     * @param \App\Http\Requests\ReservationStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationStoreRequest $request)
    {
        $this->authorize('create', Reservation::class);

        $validated = $request->validated();

        $reservation = Reservation::create($validated);

        return new ReservationResource($reservation);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        return new ReservationResource($reservation);
    }

    /**
     * @param \App\Http\Requests\ReservationUpdateRequest $request
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(
        ReservationUpdateRequest $request,
        Reservation $reservation
    ) {
        $this->authorize('update', $reservation);

        $validated = $request->validated();

        $reservation->update($validated);

        return new ReservationResource($reservation);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Reservation $reservation)
    {
        $this->authorize('delete', $reservation);

        $reservation->delete();

        return response()->noContent();
    }
}
