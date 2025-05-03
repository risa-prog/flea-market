@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/item.css')}}">
@endsection

@section('content')
<div class="item">
    <div class="item__image">
        <img class="item__image-inner" src="{{$item->item_image}}" alt="">
         <img class="item__image-inner" src="{{asset('storage/'.$item->item_image)}}" alt="">
    </div>
    <div class="item__content">
        <div class="item__content-detail">
            <h2 class="item__content-heading">{{$item->item_name}}</h2>
            <p class="item__content-brand">{{optional($item)->brand_name}}</p>
            <p class="item__content-price"><span class="item__content-price-span">¥</span>{{$item->price}}<span>(税込)</span></p>
            <div class="item__content-icons">
                <div class="item__content-icon">
                    @if($item->is_like())
                    <a href="/item/:item/unlike?item_id={{$item->id}}" class="item_unlike">
                        <i class="fa-sharp fa-regular fa-thumbs-up fa-2x"></i>
                    </a>
                    @else
                    <a href="/item/:item/like?item_id={{$item->id}}" class="item_like">
                        <i class="fa-sharp fa-regular fa-thumbs-up fa-2x"></i>
                    </a>
                    @endif
                    <p class="item__content-count">{{$item->likes->count()}}</p>
                </div>
                <div class="item__content-icon">
                    <i class="fa-regular fa-comment fa-2x"></i>
                    <p class="item__content-count">{{$item->comments->count()}}</p>
                </div>
            </div>
            <div class="item__content-button">
                    <a href="/purchase/:item_id?id={{$item->id}}" class="item__content-submit">購入手続きへ</a>
            </div>
        </div>
        <div class="item__description">
            <h3 class="item__description-heading">商品説明</h3>
            <p class="item__description-text">{{$item->description}}</p>
        </div>
        <div class="item__information">
            <div class="item__information-content">
                <h3 class="item__information-heading">商品の情報</h3>
                <table class="item__table">
                    <tr class="item__table-row">
                        <th class="item__table-heading">カテゴリー</th>
                        <td class="item__table-data">
                            <div class="item__table-wrap">
                            @foreach($categories as $category)
                                <span class="item__table-span">{{$category->content}}</span>
                            @endforeach
                            </div>
                        </td> 
                        
                    </tr>
                    <tr class="item__table-row">
                        <th class="item__table-heading">商品の状態</th>
                        <td class="item__table-data">
                            @if($item->condition==1)
                                良好
                            @elseif($item->condition==2)
                                目立った傷や汚れなし
                            @elseif($item->condition==3)
                                やや傷や汚れあり
                            @else
                                状態が悪い
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="item__comment">
            <div class="item__comment-content">
                    <h3 class="item__comment-heading">コメント({{$item->comments->count()}})</h3>
                    @if($comments != null)
                    @foreach($comments as $comment)
                    <div class="item__comment-inner">
                        <div class="item__comment-image">
                            <img class="item__comment-image-inner" src="{{asset('storage/'.optional($comment->user->profile)->profile_image)}}" alt="">
                        </div>
                        <p class="item__comment-user">
                            {{$comment->user->member->user_name}}
                        </p>
                    </div>
                    <p class="item__comment-text">{{$comment->content}}</p>
                    @endforeach
                    @endif
            </div>
            <div class="comment-form">
                <form action="/item_comment" method="post">
                @csrf
                    <p class="comment-form__text">商品へのコメント</p>
                    <div class="comment-form__content">
                        <textarea class="comment-form__textarea" name="content">{{old('content')}}</textarea>
                    </div>
                    @error('content')
                    <div class="comment-form__error">
                        <p class="comment-form__error-message">
                            {{$message}}
                        </p>
                    </div>
                     @enderror
                    <div class="comment-form__button">
                        <input type="hidden" name="item_id" value="{{$item->id}}">
                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                        <button class="comment-form__submit">コメントを送信する</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- git -->
@endsection

