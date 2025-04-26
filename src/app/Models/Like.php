<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $guarded=array('id');
    protected $fillable=[
        'user_id','item_id'
    ];

    public function item(){
        return $this->belongsTo('App\Models\Item');
    }
}

            