@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}">
@endsection

@section('content')
@if(session('message'))
<div class="home__session">
    <p id="message">{{session('message')}}</p>
</div>
@endif
<div class="purchase">
    <div class="purchase-content">
        <div class="item-content">
            <div class="item-image">
                <img src="{{$item->item_image}}" alt="">
                <img src="{{asset('storage/'.$item->item_image)}}" alt="">
            </div>
            <div class="item-detail">
                <p class="item-name">{{$item->item_name}}</p>
                <p class="item-price">¥{{$item->price}}</p>
            </div>
        </div>
        <div class="purchase__payment-detail">
            <table class="purchase-table">
                <tr class="purchase-table__row">
                    <th class="purchase-table__heading">商品代金</th>
                    <td class="purchase-table__data"><span>¥</span>{{$item->price}}</td>
                </tr>
                <tr class="purchase-table__row">
                    <th class="purchase-table__heading">支払い方法</th>
                    <td class="purchase-table__data"><span id="payment"></span></td>
                </tr>
            </table>
        </div>
    </div>
    <form action="{{ route('order', ['item_id' => $item->id]) }}" method="post" class="purchase-form">
        @csrf
        <div class="purchase-form__content">
            <label class="purchase-form__label">お支払い方法</label>
            <select class="purchase-form__selectbox" name="payment_method" id="select">
                <option value="" disabled selected>選択してください</option>
                <option value="1" id="option1">コンビニ払い</option>
                <option value="2" id="option2">カード支払い</option>
            </select>
            @error('payment_method')
            <div class="purchase-form__error">
                <p class="purchase-form__error-message">{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="purchase-form__button">
            @if(empty($item->order) && empty($item->transaction))
            <input type="hidden" name="post_code" value="{{ $member['post_code'] }}">
            <input class="shipping-address__input" type="hidden" name="address" value="{{ $member['address'] }}">
            <input type="hidden" name="building" value="{{ $member['building'] }}">
            <button class="purchase-form__submit" type="submit">購入する</button>
            @else
            <p>Sold</p>
            @endif
        </div>
    </form>
    <form class="shipping-address" action="{{ route('address', ['item_id' => $item->id]) }}" method="post">
        @csrf
        <div class="shipping-address__form">
            <div class="shipping-address__flex">
                <p class="shipping-address__text">配送先</p>
                <button class="shipping-address__button" type="submit">変更する</button>
            </div>
            <div class="shipping-address__post-code">
                <span>〒</span>
                <input class="shipping-address__form-input" type="text" name="post_code2" value="{{ $member['post_code']}}" readonly>
            </div>
            <div class="shipping-address__address">
                <input class="shipping-address__form-input" type="text" name="address2" value="{{ $member['address'] }}" readonly>
                <input class="shipping-address__form-input" type="text" name="building2" value="{{ $member['building'] }}" readonly>
            </div>
        </div>
    </form>
</div>
<script>
    const select = document.getElementById('select');
    const payment = document.getElementById('payment');
    const option1 = document.getElementById('option1').textContent;
    const option2 = document.getElementById('option2').textContent;

    select.addEventListener('change', function() {
        if (select.value == '1') {
            payment.textContent = option1;
        } else {
            payment.textContent = option2;
        }
    });

    const message = document.getElementById('message');
    setTimeout(() => {
        message.style.display = 'none';
    }, 5000);

    if (message.textContent === 'その商品は購入できません') {
        message.style.color = '#721c24';
        message.style.backgroundColor = '#f8d7da';
        message.style.padding = '10px';
        message.style.borderRadius = '4px';
    } else if (message.textContent === '商品を購入しました') {
        message.style.color = '#155724'; 
        message.style.backgroundColor = '#d4edda'; 
        message.style.padding = '10px';
        message.style.borderRadius = '4px';
    }
</script>
@endsection