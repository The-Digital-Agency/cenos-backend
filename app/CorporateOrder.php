<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorporateOrder extends Model
{
    // protected $fillable = [
    //     'name', 'rep_name' , 'rep_number' , 'delivery_date' , 'delivery_time', 'items', 'order_amount',
    //     'order_status', 'payment_method', 'payment_status', 'channel', 'location_id', 'company_id'
    // ];

    protected $guarded = [];

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function rider()
    {
        return $this->belongsTo('App\Company');
    }
}
