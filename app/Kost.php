<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    protected $fillable = ['user_id', 'name', 'address', 'city', 'phone'];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function rooms()
    {
      return $this->hasMany(Room::class);
    }
}
