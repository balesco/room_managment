<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Resources\RoomResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomCollection;
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
            ->paginate();

        return new RoomCollection($rooms);
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

        return new RoomResource($room);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Room $room)
    {
        $this->authorize('view', $room);

        return new RoomResource($room);
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

        return new RoomResource($room);
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

        return response()->noContent();
    }
}
