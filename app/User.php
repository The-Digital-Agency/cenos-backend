<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email', 'password', 'phone', 'address', 'address_2', 'location_id', 'special_date', 'piggyvest_id', 'status',
        'admin_role', 'role'
    ];

    protected $appends = [
        'delivery_location'
    ];

    public function getDeliveryLocationAttribute()
    {
        return $this->location;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function successOrders()
    {
        return $this->hasMany(Order::class, 'billing_email', 'email')->where('payment_status', 'success');
    }

    // Boilerplate
    public function orders()
    {
        return Order::where('user_id', $this->id)->orWhere('billing_email', $this->email)->get();
    }
}
