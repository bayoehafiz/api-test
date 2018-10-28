<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api')->except(['index', 'show']);
    // }

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
            'kost_id' => $this->kost_id,
            'name' => $this->name,
            'price' => $this->price,
            'payment_type' => $this->payment_type,
            'available' => $this->available,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'kost' => $this->kost,
        ];
    }
}
