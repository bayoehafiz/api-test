<?php

namespace App\Http\Controllers;

use App\Credit;
use App\CreditUsage;
use App\Http\Resources\CreditUsageResource;
use Illuminate\Http\Request;

class CreditUsageController extends Controller
{
    public function store(Request $request, Credit $credit)
    {
        $parent_credit = $credit->where('id', $request->credit_id)->first();

        // check if credit is sufficient
        if ($parent_credit->amount - $request->amount > 0) {
            $credit_usage = CreditUsage::create([
                'user_id' => $request->user()->id,
                'credit_id' => $request->credit_id,
                'amount' => $request->amount,
                'usage_for' => $request->usage_for
            ]);

            // then deduct related Credit's amount
            $parent_credit->amount = $parent_credit->amount - $request->amount;
            $parent_credit->save();

        } else {
            return response()->json(['error' => 'Insufficient credits.'], 403);
        }

        return response()->json([
            'message' => 'Credit successfully applied',
        ], 202);
    }

    public function listByCredit($id, Credit $credit, CreditUsage $credit_usage)
    {
        // check if Credit record exists
        if ($credit->where('id', $id)->exists()) {
            return CreditUsageResource::collection(CreditUsage::where('credit_id', $id)->paginate(10));
        }

        return response()->json([
            'message' => 'No credit found!'
        ], 400);
    }
}
