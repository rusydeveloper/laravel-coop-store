<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'unique_id', 
        'business_id',
        'user_id', 
        'name',
        'brand',
        'unit',
        'status',
        'balance'
    ];

    public function user(){
        return $this->belongsTo(User::class);
   }
   public function business(){
        return $this->belongsTo(Business::class);
   }
   public function inventoryhistory(){
    return $this->hasMany(InventoryHistory::class);
}
}
