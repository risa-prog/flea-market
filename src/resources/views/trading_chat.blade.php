@extends('layouts.default')

@section('css')
<link rel="stylesheet" href="{{asset('css/trading_chat.css')}}">
@endsection

@section('content')
<div class="trading-chat">
    <div class="trading-chat__side">
        <h3 class="trading-chat__side-ttl">その他の取引</h3>
        <ul class="trading-chat__side-list">
            @foreach($transactions as $transaction)
            <li>
                <a href="/trading_chat?item_id={{$transaction->item->id}}">
                    {{$transaction->item->item_name}}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="trading-chat__content">
        <div class="trading-chat__top">
            <div class="trading-chat__ttl">
                <div class="trading-chat__user-image">
                    <img src="" alt="">
                </div>
                <h2 class="trading-chat__ttl-text">「{{$client->member->user_name}}」さんとの取引画面</h2>
            </div>
            @if(Auth::id() === $item->transaction->buyer_id && $item->transaction->status === 1)
            <form action="/item/transaction/complete?transaction_id={{$item->transaction->id}}" method="post">
                @csrf
                <button>取引を完了する</button>
            </form>
            @endif
        </div>
        <div class="trading-chat__content-item">
            <div class="trading-chat__item-image">
                <img src="{{$item->item_image}}" alt="">
                <img src="{{asset('storage/' . $item->item_image)}}" alt="">
            </div>
            <div class="trading-chat__item-detail">
                <h3 class="trading-chat__item-name">{{$item->item_name}}</h3>
                <p class="trading-chat__item-price"><span>¥</span>{{$item->price}}</p>
            </div>
        </div>
        <div class="trading-chat__comment">
            @if(!empty($item->transaction->transactionComments))
            @php
            $client_comments = $item->transaction->transactionComments->where('sender_id','!=',Auth::id());
            @endphp
            @foreach($client_comments as $client_comment)
            <div class="trading-chat__comment-client">
                <div class="trading-chat__comment-image">
                    <img src="{{asset('storage/'.optional($client_comment)->image)}}" alt="">
                    <p class=" trading-chat__comment-user">{{$client->member->user_name}}</p>
                </div>
                <p>{{ $client_comment->content }}</p>
            </div>
            @endforeach
            @endif
            @if(!empty($my_transaction_comments))
            @for ($i = 0; $i < count($my_transaction_comments); $i++)
                @php
                $my_transaction_comment=$my_transaction_comments[$i];
                @endphp
                <div class="trading-chat__comment-myself">
                <p>{{Auth::user()->member->user_name}}</p>
                <div class="trading-chat__comment-myself-image">
                    <img src="{{asset('storage/'.optional($my_transaction_comment)->image)}}" alt="">
                </div>
        </div>
        <form action="{{ route('comment.edit') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$my_transaction_comment->id}}">
            <input type="hidden" name="item_id" value="{{$item->id}}">
            @error("content2.$i")
            <div class="error">
                <p class="error-message">{{ $message }}</p>
            </div>
            @enderror
            <textarea name="content2[{{$i}}]">{{ old("content2.$i",$my_transaction_comment->content) }}</textarea>
            <div>
                <button name="action" value="delete">
                    削除
                </button>
                <button name="action" value="update">
                    編集
                </button>
            </div>
        </form>
    </div>
    @endfor
    @endif
</div>

<div>
    <form class="comment-add-form" action="/trading_chat/comment/create" method="post" enctype="multipart/form-data">
        @csrf
        <div class="error">
            @error('content')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div class="error">
            @error('image')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <textarea name="content" placeholder="取引メッセージを記入してください">{{ old('content', session('content')) }}</textarea>
            <label for="image">画像を追加</label>
            <input type="file" name="image" id="image">
            <input type="hidden" name="transaction_id" value="{{$item->transaction->id}}">
            <input type="hidden" name="item_id" value="{{$item->id}}">
            <button>c</button>
        </div>
    </form>
</div>
</div>
</div>
@endsection