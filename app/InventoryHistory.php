<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    protected $fillable = [
        'unique_id', 
        'user_id', 
        'business_id',
        'inventory_id',
        'type',
        'status',
        'quantity',
        'price',
        'amount',
        'recorded_date',
        'description',
    ];

    public function user(){
        return $this->belongsTo(User::class);
   }
   public function business(){
        return $this->belongsTo(Business::class);
   }
    public function inventory(){
        return $this->belongsTo(Inventory::class);
    }
}
