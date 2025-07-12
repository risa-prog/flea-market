<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Member;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Category;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\Shipping_AddressRequest;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function search(Request $request){
        $query = Item::query();

        if(!empty($request->keyword)){
            $items = $query->where(function ($q) use ($request){
                $q->where('item_name','like','%'.$request->keyword.'%');
            })->get();
        }else{
            $items = '';
        }
        return view('index',compact('items'));
    }

    public function index(Request $request) {
        if(empty($request->tab)) {
            $items=Item::where('user_id','!=',Auth::id())->get();
         }elseif($request->tab === "mylist"){
             $items=Item::with('likes')->whereHas('likes',function ($query) {
                 $query->where('user_id',Auth::id());
             })->get();
         }elseif($request->tab === "recommendation"){
            $items=Item::withCount('likes')->orderBy('likes_count','desc')->where('user_id','!=',Auth::id())->get();
        }
         
        return view('index',compact('items'));
    }
    
    public function sell(){
        $categories=Category::all();
        return view('sell',compact('categories'));
    }

    public function item(Request $request){
        $item_id=$request->id;
        $item=Item::find($item_id);
        
        $item['category_id']=explode(',',$item['category_id']);
        $categories_id=$item['category_id'];
        
        foreach($categories_id as $category_id){
            $category=Category::find($category_id);
            $categories[]=$category;
        }

        $comments=Comment::with('item')->whereHas('item',function ($query) use ($item_id) {
             $query->where('item_id',$item_id);
          })->get();

        return view('item',compact('item','comments','categories'));
    }

    public function purchase(Request $request){
        $item = Item::find($request->id);
        $user = Auth::user();
        $member = Member::where('user_id',$user->id)->first();
        $profile = $member->profile_image;

        if(empty($member)){
            return view('profile',compact('member','profile'));
        }else{
            $member=$user->member->only(['post_code','address','building']);
            return view('purchase',compact('item','member'));
        }
    }

    public function address(Request $request){
        $item_id = $request->id;
        $user = Auth::user();
        $member = $user->member->only(['post_code','address','building']);
        
        return view('address',compact('member','item_id'));
    }

    public function comment(CommentRequest $request){
        $user = Auth::user();
        $member = Member::where('user_id',$user->id)->first();
        $profile = $member->profile_image;

        if(empty($member)){
            return view('profile',compact('member','profile'));
        }else{
            $comment = $request->all();
            unset($comment['_token']);
            Comment::create($comment);

            $previousUrl = url()->previous();
            return redirect()->to($previousUrl.'?'. http_build_query(['id'=>$comment['item_id']]))->withInput();
        }
    }
    
    public function edit(Shipping_AddressRequest $request) {
        $member = $request->only(['post_code','address','building']);
        $item_id = $request->item_id;
        $item = Item::find($item_id);
        return view('purchase',compact('member','item'));
    }

    public function order(PurchaseRequest $request){
        $order = $request->all();
        unset($order['_token']);
        $user_id = Auth::id();
        $order = array_merge($order,array('user_id'=>"$user_id"));

        $item = Item::find($request->item_id);

        if($user_id === $item->user_id){
            $request->session()->flash('message','その商品は購入できません');
        }else{
            Order::create($order);

            $request->session()->flash('message','商品を購入しました');
        }

        $previousUrl = app('url')->previous();
        return redirect()->to($previousUrl.'?'. http_build_query(['id'=>$order['item_id']]))->withInput(); 

    }

    public function create(ExhibitionRequest $request){
        $item=$request->all();
        unset($item['_token']);
        $user_id=Auth::id();
        $item=array_merge($item,array('user_id'=>"$user_id"));
        
        $item['category_id']=implode(",",$item['category_id']);
        
        $image_name=$request->item_image->getClientOriginalName();
        
        $image=$request->item_image->storeAs('',$image_name,'public');
        
        $item['item_image']=$image;

        Item::create($item);
        
        $request->session()->flash('message','商品を出品しました');
        return redirect('/sell');
    }
}