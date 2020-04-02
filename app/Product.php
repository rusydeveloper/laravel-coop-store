<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id', 
        'unique_id', 
        'business_id',
        'category_id',
        'barcode',
        'name',
        'type',
        'category',
        'subcategory',
        'tag',
        'description',
        'image',
        'price',
        'buying_price',
        'stock',
        'status',
        'info_1',
        'info_2',
        'info_3',
        'info_4',
        'info_5',
    ];

    public function user(){
        return $this->belongsTo(User::class);
   }
   public function business(){
        return $this->belongsTo(Business::class);
   }
   public function category(){
        return $this->belongsTo(Category::class);
   }

   public function order(){
    return $this->hasMany(Order::class);
}

   public function picture(){
        return $this->hasMany(Picture::class);
    }

   public function packages()
    {
        return $this->belongsToMany('App\Package');
    }
}
