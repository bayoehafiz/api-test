<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditUsage extends Model
{
    protected $fillable = ['credit_id', 'user_id', 'amount', 'usage_for'];

    public function credit() {
        return $this->belongsTo(Credit::class);
    }
}
