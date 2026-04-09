<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCycle extends Model
{
    protected $fillable = ['user_id', 'month', 'year', 'credit_limit', 'spent_amount', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
