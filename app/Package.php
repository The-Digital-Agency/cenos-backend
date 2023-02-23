<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name', 'sku', 'description', 'content', 'type', 'price', 'product_image', 'featured_image'
    ];

    protected $appends = ['full_content'];

    // Mutations
    public function getFullContentAttribute()
    {
        if ($this->type != 'drink' && $this->type != 'single' && $this->content) {
            $contentObject    = json_decode($this->content, true);
            $richContentArray = [];
            foreach ($contentObject as $itemID => $itemQuantity) {
                $itemInstance             = self::find(intval($itemID));
                $itemInstance['quantity'] = $itemQuantity;
                array_push($richContentArray, $itemInstance);
            }

            return $richContentArray;
        }
    }

    // Relationship
    public function orders()
    {
        // return $this->hasManyThrough('App\Order', 'package_order', 'App\Package');
        return $this->belongsToMany(
            'App\Order',
            'package_order',
            'package_id',
            'order_id'
        );
    }
}
