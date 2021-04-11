<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\ReservationUpdateRequest;
use DateTime;

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
            ->paginate(5);

        return view(
            'app.reservations.index',
            compact('reservations', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Reservation::class);

        $users = User::pluck('name', 'id');
        $rooms = Room::pluck('name', 'id');

        return view('app.reservations.create', compact('users', 'rooms'));
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

        return redirect()
            ->route('reservations.edit', $reservation)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Reservation $reservation)
    {
        $this->authorize('view', $reservation);

        return view('app.reservations.show', compact('reservation'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $users = User::pluck('name', 'id');
        $rooms = Room::pluck('name', 'id');

        return view(
            'app.reservations.edit',
            compact('reservation', 'users', 'rooms')
        );
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

        return redirect()
            ->route('reservations.edit', $reservation)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('reservations.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function getJSONReservations($id)
    {
        $room = Room::find($id);
        $reservations = $room->reservations;
        $data = [];
        foreach ($reservations as $key => $reservation) {
            $today = date("Y-m-d H:i:s");
            $start = $reservation->date->format('Y-m-d') . ' ' . $reservation->begin_at;
            $d = [
                'title' => $reservation->description,
                'start' => $start,
                'end' => $reservation->date->format('Y-m-d') . ' ' . $reservation->end_at,
                'className' => $today === $start ? 'bg-danger' : ($today < $start ? 'bg-warning' : "bg-success"),
            ];
            array_push($data, $d);
        }
        return response()->json($data, 200);
    }
}
