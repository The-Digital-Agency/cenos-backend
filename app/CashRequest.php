<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashRequest extends Model
{
    
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'itemRequest', 'amount','date_of_expense','expense_type','approval_type','user','status'
    ];

    


}
