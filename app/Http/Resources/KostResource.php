<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KostResource extends JsonResource
{
    // public function __construct()
    // {
    //   $this->middleware('auth:api')->except(['index', 'show']);
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
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'phone' => $this->phone,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'available_rooms' => $this->rooms->where('available', '=', '1')->count(),
            'rooms' => $this->rooms,
            'user' => $this->user
        ];
    }

}
