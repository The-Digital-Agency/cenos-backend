<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillables = ['key', 'value'];

    public static function tax()
    {
        $setting = self::where('key', 'tax')->first();

        return json_decode($setting->value, true);
    }
}
