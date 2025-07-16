@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
<link rel="stylesheet" href="{{asset('css/common.css')}}">
@endsection

@section('content')
<div class="home">
    @if (session('success'))
    <div class="alert-success">
        <p class="session-message">{{ session('success') }}</p>
    </div>
    @endif
    <div class="home__links">
        <div class="home__link">
            <a class="home__link-recommendation" href="/?tab=recommendation">おすすめ</a>
        </div>
        <div class="home__link">
            <a class="home__link-mylist" href="/?tab=mylist">マイリスト</a>
        </div>
    </div>
    <div class="home__item">
        @if(!empty($items))
        @foreach($items as $item)
        <div class="home__item-content">
            <div class="home__item-image">
                <a href="/item/:item_id?id={{$item->id}}">
                    <img src="{{asset('storage/'.$item->item_image)}}" alt="">
                    <img src="{{$item->item_image}}" alt="">
                </a>
            </div>
            <div class="home__item-link">
                <a href="/item/:item_id?id={{$item->id}}" class="home__item-link-transition">{{$item->item_name}}</a>
            </div>
            @if($item->order != null)
            <label>Sold</label>
            @endif
            @if(!$item->transaction)
            <form action="{{ route('purchase.transaction',['item_id' => $item->id]) }}" method="post">
                @csrf
                    <button>取引する</button>
                </form>
                @endif
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection