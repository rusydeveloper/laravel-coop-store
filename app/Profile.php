<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'name_nick', 
        'gender', 
        'place_of_birth',
        'work',
        'dob',
        'address',
        'village',
        'district',
        'city',
        'province',
        'country',
        'post_code',
        'phone',
        'cell_phone',
        'unique_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
   }
}
