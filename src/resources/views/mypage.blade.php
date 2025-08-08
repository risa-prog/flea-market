@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}">
@endsection

@section('content')
<div class="mypage">
    <div class="mypage__top">
        <div class="mypage__user">
            <div class="mypage__user-image">
                <img class="mypage__user-image-inner" src="{{asset('storage/'.optional($member)->profile_image)}}" alt="">
            </div>
            <div class="mypage__user-detail">
                <h2 class="mypage__user-name">{{$member->user_name}}</h2>
                @if(!is_null($averageRating))
                <div class="mypage__user-review">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $averageRating)
                        <span style="color: gold;" class="mypage__user-review-star">★</span>
                        @else
                        <span style="color: lightgray;" class="mypage__user-review-star">★</span>
                        @endif
                        @endfor
                </div>
                @endif
            </div>
        </div>
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
        <div>
            <a href="/mypage?tab=transaction" class="mypage__link-trading-chat-access">取引中の商品</a>
            <span class="mypage__link-span">{{ $unreadCount }}</span>
        </div>
    </div>
    <div class="mypage__item">
        @foreach($items as $item)
        @if(!is_null($item->transaction))
        <div class="mypage__item-group">
            @php
            $unreadComments = collect();
            if(!is_null($item->transaction->transactionComments)) {
            $unreadComments = $item->transaction->transactionComments->where('is_read', 1)->where('receiver_id', Auth::id());
            }
            @endphp
            <div class="mypage__item-image">
                <a href="/trading_chat?item_id={{$item->id}}">
                    <img class="mypage__item-image-inner" src="{{$item->item_image}}" alt="">
                    <img class="mypage__item-image-inner" src="{{asset('storage/' . $item->item_image)}}" alt="">

                    @if($unreadComments->isNotEmpty())
                    <div class="unread-message">
                        <p class="unread-message__count">{{ $unreadComments->count() }}</p>
                    </div>
                    @endif
                </a>
            </div>
            <a href="/trading_chat?item_id={{$item->id}}" class="transaction-item-link">{{$item->item_name}}</a>
            @if($item->transaction->status === 2)
            <p class="transaction-complete">取引完了</p>
            @endif
        </div>
        @else
        <div class="mypage__item-group">
            <div class="mypage__item-image">
                <img class="mypage__item-image-inner" src="{{$item->item_image}}" alt="">
                <img class="mypage__item-image-inner" src="{{asset('storage/' . $item->item_image)}}" alt="">
            </div>
            <p class="mypage__item-name">{{$item->item_name}}</p>
        </div>
        @endif
        @endforeach
    </div>
    @endsection