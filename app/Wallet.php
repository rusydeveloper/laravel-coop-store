<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'unique_id', 
        'user_id', 
        'business_id',
        'status',
        'balance'
    ];

    public function user(){
        return $this->belongsTo(User::class);
   }
   public function business(){
        return $this->belongsTo(Business::class);
   }
   public function wallethistory(){
    return $this->hasMany(WalletHistory::class);
}
}
