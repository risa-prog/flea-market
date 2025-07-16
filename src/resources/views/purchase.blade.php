@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/purchase.css')}}">
@endsection

@section('content')
@if(session('message'))
    <div class="home__session">
        {{session('message')}}
    </div>
@endif
<form action="/order}}" method="post">
    @csrf
    <!-- <input type="hidden" name="item_id" value="{{$item->id}}"> -->
    <div class="purchase-form">
        <div class="purchase-form__item">
            <div class="purchase-form__item-content">
                <div class="purchase-form__item-image">
                    <img src="{{$item->item_image}}" alt="">
                    <img src="{{asset('storage/'.$item->item_image)}}" alt="">
                </div>
                <div class="purchase-form__item-inner">
                    <h3 class="purchase-form__item-ttl">{{$item->item_name}}</h3>
                    <p class="purchase-form__item-price"><span>¥</span>{{$item->price}}</p>
                </div>
            </div>
            <div class="purchase-form__table">
                <table class="purchase-form__table-inner">
                    <tr class="purchase-form__row">
                        <th class="purchase-form__heading">商品代金</th>
                        <td class="purchase-form__data"><span>¥</span>{{$item->price}}</td>
                    </tr>
                    <tr class="purchase-form__row">
                        <th class="purchase-form__heading">支払い方法</th>
                        <td class="purchase-form__data"><span id="payment"></span></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="purchase-form__order">
            <div class="purchase-form__order-content">
                <div class="purchase-form__order-group">
                    <label class="purchase-form__order-label">支払い方法</label>
                    <div class="purchase-form__order-select">
                        <select class="purchase-form__order-selectbox" name="payment_method" id="select">
                            <option value="" disabled selected>選択してください</option>
                            <option value="1"><span id="option1">コンビニ払い</span></option>
                            <option value="2"><span id="option2">カード支払い</span></option>
                        </select>
                    </div>
                    @error('payment_method')
                    <div class="purchase-form__error">
                        <p class="purchase-form__error-message">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div class="purchase-form__shipping">
                    <div class="purchase-form__shipping-flex">
                        <label class="purchase-form__shipping-label">配送先</label>
                        <div class="purchase-form__link">
                            <button name="button" value="address">変更する</button>
                        </div>
                    </div>
                    <div class="purchase-form__shipping-address">
                        <span>〒</span>
                        <input type="text" name="post_code" value="{{ $member['post_code']}}" readonly>
                    </div>
                    <div class="purchase-form__shipping-address">
                        <input  type="text" name="address" value="{{ $member['address'] }}" readonly>
                        <input type="text" name="building" value="{{ $member['building'] }}" readonly>
                    </div>
                    @if($errors->has('post_code'))
                    <div>
                        <p>{{ $message }}</p>
                    </div>
                    @elseif($errors->has('address'))
                    <div>
                        <p>{{ $message }}</p>
                    </div>
                    @elseif($errors->has('building'))
                    <div>
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="purchase-form__button">
                @if(empty($item->order))
                <button name="button" value="purchase" class="purchase-form__submit">購入する</button>
                @else
                <p>Sold</p>
                @endif
            </div>
        </div>
    </div>
</form>
<script>
    var select = document.getElementById('select');
    var payment = document.getElementById('payment');
    var option1 = document.getElementById('option1');
    var option2 = document.getElementById('option2');

    select.addEventListener('change',function(){
        if(select.value == '1'){
            payment.textContent = option1.textContent;
        }else{
            payment.textContent = option2.textContent;
        } 
    });
</script>
@endsection