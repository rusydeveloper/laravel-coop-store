<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
    	'name', 
    	'description', 
        'user_id', 
        'unique_id', 
        'business_id',
        'price',
        'info_1',
        'info_2',
        'info_3',
    ];

public function user(){
        return $this->belongsTo(User::class);
   }
   public function business(){
        return $this->belongsTo(Business::class);
   }

   public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function picture(){
        return $this->hasMany(Picture::class);
    }

}
