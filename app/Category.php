<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = [
        'user_id', 
        'business_id', 
        'unique_id', 
        'name',
        'status',
        'parent',
        'image',
        'description',
    ];
    public function user(){
        return $this->belongsTo(User::class);
   }
   public function business(){
        return $this->belongsTo(Business::class);
   }

   public function product(){
     return $this->hasMany(Product::class);
 }
}
