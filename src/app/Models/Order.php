<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded=array('id');
    protected $fillable=[
        'item_id',
        'user_id',
        'payment_method','post_code','address','building'
    ];
}

            