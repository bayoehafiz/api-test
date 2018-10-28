<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreditUsageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'credit_id' => $this->credit_id,
            'amount' => $this->amount,
            'usage_for' => $this->usage_for,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'credit' => $this->credit,
        ];
    }
}
