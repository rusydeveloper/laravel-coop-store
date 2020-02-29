<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'role',
        'status',
        'phone',
        'unique_id',
        'firebase_user_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile(){
        return $this->hasOne(Profile::class);
    }
    public function business(){
        return $this->hasMany(Business::class);
    }
    public function order(){
        return $this->hasMany(Order::class);
    }
    public function package(){
        return $this->hasMany(Package::class);
    }
    public function picture(){
        return $this->hasMany(Picture::class);
    }
    public function product(){
        return $this->hasMany(Product::class);
    }

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }
    

}
