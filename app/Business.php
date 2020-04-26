<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'user_id', 
        'name', 
        'status', 
        'description',
        'category',
        'subcategory',
        'contact',
        'address',
        'city',
        'village',
        'district',
        'province',
        'country',
        'picture',
        'unique_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
   }

   public function product(){
        return $this->hasMany(Product::class);
    }

    public function business(){
        return $this->hasMany(Business::class);
    }

    public function picture(){
        return $this->hasMany(Picture::class);
    }

    public function order(){
        return $this->hasMany(Order::class);
    }

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }

    public function package(){
        return $this->hasMany(Package::class);
    }


}
