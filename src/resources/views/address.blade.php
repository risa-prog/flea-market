@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/address.css')}}">
@endsection

@section('content')
    <div class="address-form">
        <form action="/purchase/address/:item_id?item_id={{$item_id}}" method="post">
            @method('patch')
            @csrf
            <div class="address-form__ttl">
                <h2>住所の変更</h2>
            </div>
            <div class="address-form__group">
                <label class="address-form__label">郵便番号</label>
                <div class="address-form__item">
                    <input class="address-form__input" type="text" name="post_code" value="{{ $member->post_code }}">
                </div>
                <div class="address-form__error">
                    @error('post_code')
                    <p class="address-form__error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="address-form__group">
                <label class="address-form__label">住所</label>
                <div class="address-form__item">
                    <input class="address-form__input" type="text" name="address" value="{{ $member->address }}">
                </div>
                <div class="address-form__error">
                    @error('address')
                    <p class="address-form__error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="address-form__group">
                <label class="address-form__label">建物名</label>
                <div class="address-form__item">
                    <input class="address-form__input" type="text" name="building" value="{{ $member->building }}">
                </div>
                <div class="address-form__error">
                    @error('building')
                    <p class="address-form__error-message">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="address-form__button">
                <button class="address-form__submit" type="submit">
                    更新する
                </button>
            </div>
        </form>
    </div>

@endsection