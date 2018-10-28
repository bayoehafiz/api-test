<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoomResource;
use App\Kost;
use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return RoomResource::collection(Room::paginate(10));
    }

    public function listByKost($id, Room $room, Kost $kost)
    {   
        // check if kost record exists
        if ($kost->where('id', $id)->exists()) {
            return RoomResource::collection(Room::where('kost_id', $id)->paginate(10));
        }

        return response()->json([
            'message' => 'No kost found!',
        ], 400);
    }

    public function show(Request $request, Room $room)
    {   
        // check if such record exists
        if ($room->where('id', $request->id)->exists()) {
            return $room->where('id', $request->id)->first();
        }

        return response()->json([
            'message' => 'No room found!',
        ], 400);
    }

    public function store(Request $request)
    {
        $room = Room::create(
            [
                'user_id' => auth()->user()->id,
                'kost_id' => $request->kost_id,
                'name' => $request->name,
                'price' => $request->price,
                'payment_type' => $request->payment_type,
                'available' => $request->available
            ]
        );

        return new RoomResource($room);
    }

    public function updateStatus(Request $request, Room $room)
    {
        // check if currently authenticated user is the owner of the room
        $user = auth()->user();
        if ($user->id !== $room->where('id', $request->id)->value('user_id')) {
            return response()->json(['error' => 'You can only edit your own room.'], 403);
        }

        $room = Room::find($request->id);
        $availability = $room->value('available');
        if ($availability == 1) {
            $room->available = 0;
        } else {
            $room->available = 1;
        }

        $room->save();

        return response()->json([
            'message' => 'Room availability updated',
        ], 202);
    }
    
    public function update(Request $request, Room $room)
    {
        // check if currently authenticated user is the owner of the room
        $user = auth()->user();
        if ($request->id !== $room->where('id', $request->id)->value('user_id')) {
            return response()->json(['error' => 'You can only edit your own rooms.'], 403);
        }

        $room->where('id', $request->id)->update($request->only(['name', 'price', 'payment_type']));

        return response()->json([
            'message' => 'Room successfully updated',
        ], 202);
    }

    public function destroy(Request $request, Room $room, Kost $kost)
    {
        // check if currently authenticated user is the owner of the room
        $user = auth()->user();
        if ($user->id !== $room->where('id', $request->id)->value('user_id')) {
            return response()->json(['error' => 'You can only delete your own rooms.'], 403);
        }

        $room->where('id', $request->id)->delete();

        return response()->json(null, 204);
    }
}
