<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer', 
        'status',
        'payment',
        'amount',
        'description',
        'unique_id',
        'booking_id',
        'firebase_user_id',
        'firebase_invoice_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
   }

   public function business(){
        return $this->belongsTo(Business::class);
   }
}
