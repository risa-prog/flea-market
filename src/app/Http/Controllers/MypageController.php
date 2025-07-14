<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Member;
use App\Models\User;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionComment;

class MypageController extends Controller
{
    public function mypage(Request $request){
        $user=Auth::user();
        
        $member = Member::where('user_id',$user->id)->first();
        
        if($request->tab === "sell"){
                $items = Item::with(['user','transaction'])->whereHas('user',function ($query) {
                    $query->where('user_id',Auth::id());
                })->get();
            }elseif($request->tab === "buy"){
                $items = Item::with(['order','transaction'])->whereHas('order',function ($query) {
                    $query->where('user_id',Auth::id());
                })->get();
            }elseif($request->tab === "transaction"){
                $items = Item::with('transaction.transactionComments')
                    ->whereHas('transaction', function ($query) {
                        $query->where(function ($q) {
                            $q->where      ('buyer_id', Auth::id())
                                ->orWhere('seller_id', Auth::id());
                        });
                    })->get();
                }

        $unreadCount = TransactionComment::where('is_read', 1)
            ->whereHas('transaction', function ($query) use ($user) {
                $query->where(function ($q) use ($user) {
                    $q->where('buyer_id', $user->id)
                        ->orWhere('seller_id', $user->id);
                });
            })
            ->where('receiver_id', $user->id)
            ->get()
            ->count();

        $user = User::with('transactionReviews')->find($user->id);
        $ratings = $user->transactionReviews;

        if($ratings->isNotEmpty()){
            $averageRating = round($ratings->avg('rating'));
        }else {
            $averageRating = null;
        }

        
        return view('mypage',compact('member','items','unreadCount','averageRating'));
    }

    public function profile() {
        $user_id = Auth::id();
        $member = Member::find($user_id);
        return view('profile',compact('member'));
    }

    public function set(AddressRequest $request){
        if ($request->hasFile('profile_image')) {
            $profile_img = $request->profile_image->getClientOriginalName();
            $request->profile_image->storeAs('', $profile_img, 'public');
        } else {
            $profile_img = null;
        }

        $profile = $request->all();
        unset($profile['_token']);

        // 画像がある場合だけ、profile にセット
        if ($profile_img) {
            $profile['profile_image'] = $profile_img;
        }

        $member = Member::find($profile['id']);

        if ($member) {
            $member->update($profile);
        } else {
            Member::create($profile);
        }

        return redirect('/mypage?tab=sell');
     }
}
