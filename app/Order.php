<?php

namespace App;

use App\Coupon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['null'];
    protected $hidden = ['vendor'];

    protected $dates = ['delivery_date'];

    // protected $with = ['vendor'];

    // Serialize attributes for response
    protected $appends = [
        'deliveryLocationObject',
        'deliveryWindowString',
        'coupon',
        'vendor_name',
        'logistics_name'
    ];

    public function getDeliveryLocationObjectAttribute()
    {
        return $this->location;
    }

    public function getDeliveryWindowStringAttribute()
    {
        if ($delivery = DeliveryWindow::find($this['delivery_window'])) {
            return $delivery->deliveryWindow();
        }
    }

    public function getCouponAttribute()
    {
        return $this->couponObject();
    }

    public function getVendorNameAttribute()
    {
        return $this->vendor ? $this->vendor->name : '-';
    }
    public function getLogisticsNameAttribute()
    {
        return $this->rider ? json_decode($this->rider)->name : '-';
    }

    public function couponObject()
    {
        return Coupon::where(
            'code',
            strtoupper($this['billing_discount_code'])
        )->first();
    }

    // Relationship
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function location()
    {
        return $this->hasOne('App\Location', 'id', 'location_id');
    }

    public function rider()
    {
        return $this->belongsTo('App\Company');
    }

    public function request_rider() 
    {
        return $this->hasMany('App\RequestRider');
    }

    public function order()
    {
        return $this->hasOne('App\Transaction');
    }

    public function packages()
    {
        return $this->belongsToMany(
            'App\Package',
            'package_order',
            'order_id',
            'package_id'
        );
    }

    public function vendor()
    {
        return $this->hasOne('App\Vendor', 'id', 'vendor_id');
    }

    public function deliveryWindow()
    {
        return $this->hasOne('App\DeliveryWindow', 'id', 'delivery_window');
    }

    // Cast
    public function itemsArray()
    {
        return json_decode($this->items, true);
    }
}
