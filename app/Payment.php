<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'name', 
        'category',
        'description',
        'info_1',
        'info_2',
        'info_3',
        'info_4',
        'info_5',
        'unique_id',
    ];
}
