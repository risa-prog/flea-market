@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}">
@endsection

@section('content')
    <div class="mypage">
        <div class="mypage__user">
            <div class="mypage__user-image">
                <img class="mypage__user-image-inner" src="{{asset('storage/'.optional($profile)->profile_image)}}" alt="">
            </div>
            <h2 class="mypage__user-name">{{$member->user_name}}</h2>
            <div class="mypage__user-link">
                <a class="mypage__user-link-edit" href="/mypage/profile">プロフィールを編集</a>
            </div>
        </div>
        <div class="mypage__link">
            <div class="mypage__link-exhibit">
                <a class="mypage__link-exhibit-access" href="/mypage?tab=sell">出品した商品</a>
            </div>
            <div class="mypage__link-purchase">
                <a class="mypage__link-purchase-access" href="/mypage?tab=buy">購入した商品</a>
            </div>
        </div>
        <div class="mypage__item">
            @if($items != null)
            @foreach($items as $item)
            <div class="mypage__item-group">
                <div class="mypage__item-image">
                    <img class="mypage__item-image-inner" src="{{$item['item_image']}}" alt="">
                    <img class="mypage__item-image-inner" src="{{asset('storage/' . $item['item_image'])}}" alt="">
                </div>
                <p class="mypage__item-name">{{$item['item_name']}}</p>
            </div>
            @endforeach
            @endif
        </div>
    </div>
@endsection