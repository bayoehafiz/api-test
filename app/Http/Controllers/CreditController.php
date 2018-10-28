<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreditController extends Controller
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

    public function show($id)
    {
        return $kost->where('id', $request->id)->first();
    }

    public function update(Request $request, $id)
    {
        $kost = $kost->where('id', $request->id)->update($request->only(['name', 'address', 'city', 'phone']));

        return response()->json([
            'message' => 'Credit successfully updated'
        ], 202);
    }

    public function destroy($id)
    {
        $kost->where('id', $request->id)->delete();

        return response()->json([
            'message' => 'Credit successfully deleted!'
        ], 204);
    }
}
