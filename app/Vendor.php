<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $guarded = ['null'];

    public function zone()
    {
        return $this->belongsToMany(
            'App\Zone',
            'zone_vendor',
            'vendor_id',
            'zone_id'
        );
        // return $this->hasManyThrough(Comment::class, 'foreign_key', 'local_key');
    }
}
