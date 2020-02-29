<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $fillable = [
        'user_id', 
        'business_id', 
        'product_id',
        'package_id', 
        'status',
        'payment_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'quantity',
        'price',
        'description',
        'info_1',
        'info_2',
        'info_3',
        'info_4',
        'info_5',
        'unique_id',
        'booking_id',
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

   public function package(){
        return $this->belongsTo(Package::class);
   }

   public function payment(){
        return $this->belongsTo(Payment::class);
   }
}
