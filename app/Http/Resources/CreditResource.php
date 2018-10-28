<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CreditResource extends JsonResource
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
            'id' => $this->id,
            'amount' => $this->amount,
            'reset_time' => $this->reset_time,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'credit_usage' => $this->credit_usage,
            'user' => $this->user
        ];
    }
}
