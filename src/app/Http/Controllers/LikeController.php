<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;


class LikeController extends Controller
{
    public function like(Request $request){
            $item_id=$request['item_id'];
            $user_id=Auth::id();
            $like=['item_id'=>"$item_id",'user_id'=>"$user_id"];
            Like::create($like);
            
            $previousUrl = app('url')->previous();

            return redirect()->to($previousUrl.'?'. http_build_query(['id'=>$item_id]))->withInput();
    }

    public function unlike(Request $request){
        $item_id=$request['item_id'];
        
        $like=Like::where('item_id',$item_id)->where('user_id',Auth::id())->first();
        $like->delete();
        
        $previousUrl = app('url')->previous();

        return redirect()->to($previousUrl.'?'. http_build_query(['id'=>$item_id]))->withInput();

    }
}
