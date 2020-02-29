<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $fillable = [
        'user_id', 
        'unique_id', 
        'product_id', 
        'business_id',
        'package_id',
        'name',
        'status',
        'title',
        'category',
        'caption',
        'description',
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
}
