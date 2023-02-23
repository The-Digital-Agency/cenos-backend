<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankPayment extends Model
{
    protected $fillable = ['payer_name', 'ammount_paid', 'paid_at', 'status'];

    protected $dates = ['paid_at'];
}
