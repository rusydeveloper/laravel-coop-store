<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'unique_id', 
        'user_id', 
        'business_id',
        'product_id',
        'title',
        'status',
        'quantity_ordered',
        'amount_ordered',
        'product_initial_price',
        'product_initial_price_promoted',
        'product_tiering_price_1',
        'product_tiering_price_2',
        'product_tiering_price_3',
        'product_tiering_quota_1',
        'product_tiering_quota_2',
        'product_tiering_quota_3',
        'product_tiering_max',
        'start_at',
        'end_at',
        'priority',
        'info',
        'tnc',
        'promo',
        'tag_1',
        'tag_2',
        'tag_3',
    ];

    public function user(){
        return $this->belongsTo(User::class);
   }
   public function business(){
        return $this->belongsTo(Business::class);
   }
   public function product(){
    return $this->belongsTo(Product::class);
}
}
