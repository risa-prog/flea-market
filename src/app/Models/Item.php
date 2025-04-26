<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use HasFactory;

    protected $guarded=array('id');
    protected $fillable=[
        'item_name','item_image','price','description','condition','brand_name','user_id',
        'category_id'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function categories(){
        return $this->belongsMany('App\Models\Category');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    public function order(){
        return $this->hasOne('App\Models\Order');
    }

    public function likes(){
        return $this->hasMany('App\Models\Like');
    }

    public function is_like(){
        $user_id=Auth::id();

        $likers=array();
        foreach($this->likes as $like){
            array_push($likers,$like->user_id);
        }

        if(in_array($user_id,$likers)){
            return true;
        }else{
            return false;
        }
    }
}

            
            
