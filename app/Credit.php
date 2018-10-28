<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = ['user_id', 'amount', 'reset_time'];

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function credit_usage()
    {
      return $this->hasMany(CreditUsage::class);
    }
}
