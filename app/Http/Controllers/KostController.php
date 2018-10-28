<?php

namespace App\Http\Controllers;

use App\Http\Resources\KostResource;
use App\Kost;
use Illuminate\Http\Request;

class KostController extends Controller
{
    public function index()
    {
        return KostResource::collection(Kost::with('rooms')->paginate(10));
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
        return $kost->where('id', $request->id)->first();
    }

    public function update(Request $request, Kost $kost)
    {
        // check if currently authenticated user is the owner of the kost
        $user = auth()->user();
        if ($user->id !== $kost->where('id', $request->id)->value('user_id')) {
            return response()->json(['error' => 'You can only edit your own kosts.'], 403);
        }

        $kost = $kost->where('id', $request->id)->update($request->only(['name', 'address', 'city', 'phone']));

        // return new KostResource($kost);
        return response()->json(null, 202);
    }

    public function destroy(Request $request, Kost $kost)
    {
        // check if currently authenticated user is the owner of the kost
        $user = auth()->user();
        if ($user->id !== $kost->where('id', $request->id)->value('user_id')) {
            return response()->json(['error' => 'You can only edit your own kosts.'], 403);
        }

        $kost->where('id', $request->id)->delete();

        return response()->json(null, 204);
    }
}
