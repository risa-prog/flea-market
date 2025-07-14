@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/trading_chat.css')}}">
@endsection

@section('content')
<div class="trading-chat">
    <div class="trading-chat__side">
        <h3 class="trading-chat__side-ttl">その他の取引</h3>
        <ul class="trading-chat__side-list">
            @foreach($sortedTransactions as $sortedTransaction)
            <li>
                <a href="/trading_chat?item_id={{$sortedTransaction->item->id}}" class="trading-chat__side-link">
                    {{$sortedTransaction->item->item_name}}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="trading-chat__content">
        <div class="trading-chat__top">
            <div class="trading-chat__ttl">
                <div class="trading-chat__user-image">
                    <img src="{{asset('storage/' . $client->member->profile_image)}}" alt="">
                </div>
                <h2 class="trading-chat__ttl-text">「{{$client->member->user_name}}」さんとの取引画面</h2>
            </div>
            @if(Auth::id() === $item->transaction->buyer_id && $item->transaction->status === 1)
            <form action="/item/transaction/complete?transaction_id={{$item->transaction->id}}&item_id={{$item->id}}" method="post">
                @csrf
                <div class="transaction-form__button">
                    <button class="transaction-form__submit">取引を完了する</button>
                </div>
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
                <div class="trading-chat__comment-client-content">
                    <div class="trading-chat__comment-client-image">
                        <img src="{{asset('storage/'.optional($client_comment)->image)}}" alt="">
                    </div>
                    <p class=" trading-chat__comment-client-name">{{$client->member->user_name}}</p>
                </div>
                <p class="trading-chat__comment-client-text">{{ $client_comment->content }}</p>
            </div>
            @endforeach
            @endif
            @if(!empty($my_transaction_comments))
            @for ($i = 0; $i < count($my_transaction_comments); $i++)
                @php
                $my_transaction_comment=$my_transaction_comments[$i];
                @endphp
                <div class="trading-chat__comment-myself">
                <div class="trading-chat__comment-myself-content">
                    <p class="trading-chat__comment-myself-name">{{Auth::user()->member->user_name}}</p>
                    <div class="trading-chat__comment-myself-image">
                        <img src="{{asset('storage/'.optional($my_transaction_comment)->image)}}" alt="">
                    </div>
                </div>
                <form action="{{ route('comment.edit',['id' => $my_transaction_comment->id, 'item_id' => $item->id]) }}" method="post" class="my-comment-form">
                    @csrf
                    @error("content2.$i")
                    <div class="error">
                        <p class="error-message">{{ $message }}</p>
                    </div>
                    @enderror
                    <textarea name="content2[{{$i}}]" class="my-comment-form__textarea">{{ old("content2.$i",$my_transaction_comment->content) }}</textarea>
                    <div class="my-comment-form__button">
                        <button name="action" value="delete" class="my-comment-form__button-delete">
                            削除
                        </button>
                        <button name="action" value="update" class="my-comment-form__button-update">
                            編集
                        </button>
                    </div>
                </form>
        </div>
        @endfor
        @endif
    </div>
    <div class="trading-chat-form">
        <form action="/trading_chat/comment/create?transaction_id={{$item->transaction->id}}&item_id={{$item->id}}" method="post" enctype="multipart/form-data">
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
            <div class="trading-chat-form__item">
                <textarea class="trading-chat-form__textarea" name="content" placeholder="取引メッセージを記入してください">{{ old('content', session('form_data.content')) }}</textarea>
                <label class="trading-chat-form__label" for="image">画像を追加</label>
                <input class="trading-chat-form__input" type="file" name="image" id="image">
                <!-- <div class="trading-chat-form__button"> -->
                <button class="trading-chat-form__submit">
                    <img class="trading-chat-form__image" src="{{asset('img/send_icon_128761.png')}}" alt="">
                </button>
                <!-- </div> -->
            </div>
        </form>
    </div>
</div>
</div>
<!-- モーダル -->
@if (!$hasReviewed && $item->transaction->status === 2)
<div id="ratingModal" class="transaction-modal">
    <div class="transaction-modal__content">
        @error('rating')
        <div class="error">
            <p class="error-message">{{ $message }}</p>
        </div>
        @enderror
        <p class="transaction-modal__message">取引が完了しました。</p>
        <div class="transaction-modal__review">
            <p class="transaction-modal__review">今回の取引相手はどうでしたか？</p>
            <form action="/transaction/review?transaction_id={{$item->transaction->id}}" method="post" class="review-form">
                @csrf
                <div class="review-form__star-rating">
                    @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                    <label for="star{{ $i }}">★</label>
                    @endfor
                </div>
                <div class="review-form__button">
                    <button class="review-form__submit">送信する</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('ratingModal');
        if (modal) {
            modal.style.display = 'flex'; // 自動表示
        }
    });
</script>
@endsection