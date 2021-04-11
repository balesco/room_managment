<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\RoomStoreRequest;
use App\Http\Requests\RoomUpdateRequest;

class RoomController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Room::class);

        $search = $request->get('search', '');

        $rooms = Room::search($search)
            ->latest()
            ->get();

        return view('app.rooms.index', compact('rooms', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Room::class);

        return view('app.rooms.create');
    }

    /**
     * @param \App\Http\Requests\RoomStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomStoreRequest $request)
    {
        $this->authorize('create', Room::class);

        $validated = $request->validated();

        $room = Room::create($validated);

        return redirect()
            ->route('rooms.edit', $room)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Room $room)
    {

        return view('app.rooms.show', compact('room'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Room $room)
    {
        $this->authorize('update', $room);

        return view('app.rooms.edit', compact('room'));
    }

    /**
     * @param \App\Http\Requests\RoomUpdateRequest $request
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function update(RoomUpdateRequest $request, Room $room)
    {
        $this->authorize('update', $room);

        $validated = $request->validated();

        $room->update($validated);

        return redirect()
            ->route('rooms.edit', $room)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Room $room)
    {
        $this->authorize('delete', $room);

        $room->delete();

        return redirect()
            ->route('rooms.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
