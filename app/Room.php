<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['kost_id', 'user_id', 'name', 'price', 'payment_type', 'available'];

    public function kost() {
        return $this->belongsTo(Kost::class);
    }
}
