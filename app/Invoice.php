<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_payment_choice',
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
