<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    protected $fillable = [
        'unique_id', 
        'user_id', 
        'business_id',
        'wallet_id',
        'status',
        'type',
        'amount',
        'description',
    ];

    public function user(){
        return $this->belongsTo(User::class);
   }
   public function business(){
        return $this->belongsTo(Business::class);
   }
public function wallet(){
    return $this->belongsTo(Wallet::class);
}
}
