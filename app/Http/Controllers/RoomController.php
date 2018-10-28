<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Kost;
use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RoomResource::collection(Room()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Kost $kost)
    {
        $room = Room::create([
            'user_id' => $request->user()->id,
            'kost_id' => $kost->id,
            'name' => $request->name,
            'price' => $request->price,
            'payment_type' => $request->payment_type,
            'available' => $request->available,
        ]);

        return new RoomResource($room);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return new RoomResource($room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        // check if currently authenticated user is the owner of the room
        if ($request->user()->id !== $room->user_id) {
            return response()->json(['error' => 'You can only edit your own rooms.'], 403);
        }

        $room->update($request->only(['name', 'price', 'payment_type', 'available']));

        return new RoomResource($room);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json(null, 204);
    }
}
