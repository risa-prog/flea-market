<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Member;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function mypage(Request $request){
        $user=Auth::user();
        
        $member=Member::where('user_id',$user->id)->first();
        
        $profile=Profile::where('user_id',$user->id)->first();

        if(empty($member)){
            return view('profile',compact('member','profile'));
        }else{
            if($request->tab === "sell"){
            $items=Item::with('user')->whereHas('user',function ($query) {
                $query->where('user_id',Auth::id());
            })->get();
            }elseif($request->tab === "buy"){
             $items=Item::with('order')->whereHas('order',function ($query) {
                 $query->where('user_id',Auth::id());
             })->get();
            }elseif(empty($request->tab)){
            $items="";
            }
        }
        
        return view('mypage',compact('member','profile','items'));
    }

    public function profile(){
        $user_id=Auth::id();
        $member=Member::find($user_id);
        return view('profile',compact('member'));
    }

    public function download(ProfileRequest $request){
        $image_name=$request->profile_image->getClientOriginalName();
        $request->profile_image->storeAs('',$image_name,'public');

        $user_id=Auth::id();
        $profile=Profile::where('user_id',$user_id)->first();
        
        $profile_img['profile_image']=$image_name;
        $profile_img=array_merge($profile_img,array('user_id' => "$user_id"));

     if($profile != null){
        $profile->update($profile_img);
         }else{
            Profile::create($profile_img);
         }

        return redirect('/mypage');
    }

    public function set(AddressRequest $request){
        $member=$request->all();
        unset($member['_token']);
        
        if($member['id'] != null){
            
            Member::find($member['id'])->update($member);
        }else{
            Member::create($member);
        }
        return redirect('/');
     }

}
