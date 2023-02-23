<?php

namespace App;

use App\Order;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'value', 'percent_off', 'max_usage', 'expires_at'];
    protected $dates = ['expires_at'];

    protected $appends = ['usage'];

    public function getUsageAttribute()
    {
        return Order::where('billing_discount', '!=', 0)
        ->where('payment_status', '=', 'success')
        ->where('billing_discount_code', $this->code)
            ->count();
    }

    // Model Relationship

    // Boilerplates
    public static function findByCode($code)
    {
        return self::where('code', $code)->first();
    }

    public function discount($total)
    {
        if ($this->type == 'fixed') {
            return $this->value;
        } elseif ($this->type == 'percent') {
            return ($this->percent_off / 100) * $total;
        } else {
            return 0;
        }
    }
}
