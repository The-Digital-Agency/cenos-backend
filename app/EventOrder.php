<?php

namespace App;

use App\Location;
use Illuminate\Database\Eloquent\Model;

class EventOrder extends Model
{
    // protected $fillable = [
    //     'name', 'phone' , 'email' , 'delivery_date' , 'guest', 'items', 'order_amount',
    //     'order_status', 'payment_method', 'payment_status', 'channel', 'location_id', 'company_id'
    // ];te
    // 
    protected $dates = ['delivery_date'];

    protected $appends = [
        'location'
    ];

    public function getLocationAttribute()
    {
        return Location::where('id', $this->location_id)->first();
    }

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
