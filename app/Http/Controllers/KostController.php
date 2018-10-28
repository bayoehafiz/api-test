<?php

namespace App\Http\Controllers;

use App\Http\Resources\KostResource;
use App\Kost;
use App\User;
use Illuminate\Http\Request;

class KostController extends Controller
{
    public function index()
    {
        return KostResource::collection(Kost::with('rooms')->paginate(10));
    }

    public function listByUser($id, User $user, Kost $kost)
    {
        // check if user record exists
        if ($user->where('id', $id)->exists()) {
            return KostResource::collection(Kost::where('user_id', $id)->with('rooms')->paginate(10));
        }

        return response()->json([
            'message' => 'No user found!',
        ], 400);
    }

    public function store(Request $request)
    {
        $kost = Kost::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
        ]);

        return new KostResource($kost);
    }

    public function show(Request $request, Kost $kost)
    {
        // check if such record exists
        if ($kost->where('id', $request->id)->exists()) {
            return $kost->where('id', $request->id)->with('rooms')->first();
        }

        return response()->json([
            'message' => 'No kost found!',
        ], 400);
    }

    public function update(Request $request, Kost $kost)
    {
        // check if currently authenticated user is the owner of the kost
        $user = auth()->user();
        if ($user->id !== $kost->where('id', $request->id)->value('user_id')) {
            return response()->json(['error' => 'You can only edit your own kosts.'], 403);
        }

        $kost->where('id', $request->id)->update($request->only(['name', 'address', 'city', 'phone']));

        return response()->json([
            'message' => 'Kost successfully updated',
        ], 202);
    }

    public function destroy(Request $request, Kost $kost)
    {
        // check if currently authenticated user is the owner of the kost
        $user = auth()->user();
        if ($user->id !== $kost->where('id', $request->id)->value('user_id')) {
            return response()->json(['error' => 'You can only delete your own kosts.'], 403);
        }

        $kost->where('id', $request->id)->delete();

        return response()->json([
            'message' => 'Kost successfully deleted!',
        ], 204);
    }
}
