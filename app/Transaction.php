<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
      'order_id', 'transaction_ref', 'amount', 'payment_ref', 'status', 'channel'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
