<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $guarded=array('id');
    
    protected $fillable=[
        'user_id','user_name','profile_image','post_code','address','building',
        'profile_image',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}

            