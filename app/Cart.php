<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillables = ['user_id', 'cart_object'];

    public static function findByUser()
    {
        return self::where('user_id', Auth::id());
    }
}
