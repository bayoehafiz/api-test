<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Http\Resources\CreditResource;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function index()
    {
        return CreditResource::collection(Credit::with('credit_usage')->paginate(10));
    }

    public function listByUser($id, User $user, Credit $credit)
    {
        // check if user record exists
        if ($user->where('id', $id)->exists()) {
            return CreditResource::collection(Credit::where('user_id', $id)->with('credit_usage')->paginate(10));
        }

        return response()->json([
            'message' => 'No user found!',
        ], 400);
    }

    public function store(Request $request)
    {
        $current = Carbon::now();

        $credit = Credit::firstOrCreate([
            'user_id' => auth()->user()->id,
        ], [
            'amount' => $request->amount,
            'reset_time' => $current->addMonth(),
        ]);

        return new CreditResource($credit);
    }

    public function show(Request $request, Credit $credit)
    {
        // check if such record exists
        if ($credit->where('id', $request->id)->exists()) {
            return $credit->where('id', $request->id)->with('credit_usage')->first();
        }

        return response()->json([
            'message' => 'No credit found!',
        ], 400);
    }

    public function checkReset(Request $request, Credit $credit)
    {
        $reset_time = $credit->value('reset_time');
        $current = Carbon::now();

        if ($reset_time <= $current) {
            $credit = Credit::find($request->id);

            // check current user_type
            $current_user = auth()->user();
            if ($current_user->user_type == 'Premium') {
                $credit->amount = 40;
            } else {
                $credit->amount = 20;
            }

            $credit->save();

            return response()->json([
                'message' => 'Credit successfully reset',
            ], 202);
        }

        return response()->json([
            'message' => 'Credit is not in reset period',
        ], 202);
    }

    public function update(Request $request, Credit $credit)
    {
        // check if currently authenticated user is the owner of the credit
        $user = auth()->user();
        if ($user->id !== $credit->where('id', $request->id)->value('user_id')) {
            return response()->json(['error' => 'You can only edit your own credit'], 403);
        }

        $credit = $credit->where('id', $request->id)->update($request->only(['amount']));

        return response()->json([
            'message' => 'Credit successfully updated',
        ], 202);
    }

    public function destroy(Request $request, Credit $credit)
    {
        // check if currently authenticated user is the owner of the credit
        $user = auth()->user();
        if ($user->id !== $credit->where('id', $request->id)->value('user_id')) {
            return response()->json(['error' => 'You can only edit your own credit'], 403);
        }

        $credit->where('id', $request->id)->delete();

        return response()->json([
            'message' => 'Credit successfully deleted!',
        ], 204);
    }
}
