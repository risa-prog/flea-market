@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('css/sell.css')}}">
@endsection

@section('content')
@if(session('message'))
    <div class="sell__session">
        <p>{{session('message')}}</p>
    </div>
@endif
<div class="sell-form">
    <form action="/sell" method="post" enctype="multipart/form-data">
    @csrf
        <div class="sell-form__ttl">
            <h2>商品の出品</h2>
        </div>
        <div class="sell-form__image">
            <label class="sell-form__label">商品画像</label>
            <div class="sell-form__image-inner">
                <input class="sell-form__item-image" type="file" name="item_image">
            </div>
            @error('item_image')
            <div class="sell-form__error">
                <p class="sell-form__error-message">{{$message}}</p>
            </div>
            @enderror
        </div>
        <div class="sell-form__detail">
            <h3 class="sell-form__subtitle">商品の詳細</h3>
            <div class="sell-form__category">
                <label class="sell-form__label">カテゴリー</label>
                <div class="sell-form__category">
                    @foreach($categories as $category)
                    <div class="sell-form__category-item">
                        <label class="sell-form__label" for="{{$category->id}}">
                            <input class="sell-form__category-input" type="checkbox" name="category_id[]" value="{{$category->id}}" id="{{$category->id}}" @if((int)old('category_id[]') == $category->id )checked @endif><span class="sell-form__span">{{$category->content}}</span>
                        </label>
                    </div>
                     @endforeach
                </div>
                @error('category_id')
                <div class="sell-form__error">
                    <p class="sell-form__error-message">{{$message}}</p>
                </div>
                @enderror
            </div>
            <div class="sell-form__condition">
                <label class="sell-form__label">商品の状態</label>
                <div class="sell-form__select-item">
                    <select class="sell-form__select" name="condition" >
                        <option value="" disabled selected>選択してください</option>
                        <option value="1" @if((int)old('condition')== "1") selected @endif>良好</option> 
                        <option value="2" @if((int)old('condition')== "2") selected @endif>目立った傷や汚れなし</option>
                        <option value="3" @if((int)old('condition')== "3") selected @endif>やや傷や汚れあり</option>
                        <option value="4" @if((int)old('condition')== "4") selected @endif>状態が悪い</option>
                    </select>
                </div>
                @error('condition')
                <div class="sell-form__error">
                    <p class="sell-form__error-message">{{$message}}</p>
                </div>
                @enderror
            </div>
        </div>
        <div class="sell-form__item-description">
            <h3 class="sell-form__subtitle">商品名と説明</h3>
            <div class="sell-form__group">
                <label class="sell-form__label">商品名</label>
                <div class="sell-form__item">
                    <input class="sell-form__input" type="text" name="item_name" value="{{old('item_name')}}">
                </div>
                @error('item_name')
                <div class="sell-form__error">
                    <p class="sell-form__error-message">{{$message}}</p>
                </div>
                @enderror
            </div>
            <div class="sell-form__group">
                <label class="sell-form__label">ブランド名</label>
                <div class="sell-form__item">
                    <input class="sell-form__input" type="text" name="brand_name" value="{{old('brand_name')}}">
                </div>
            </div>
            <div class="sell-form__group">
                <label class="sell-form__label">商品の説明</label>
                <div>
                    <textarea class="sell-form__textarea" name="description">{{old('description')}}</textarea>
                </div>
                @error('description')
                <div class="sell-form__error">
                    <p class="sell-form__error-message">{{$message}}</p>
                </div>
                @enderror
            </div>
            <div class="sell-form__group">
                <label class="sell-form__label">販売価格</label>
                <div class="sell-form__item">
                    <input class="sell-form__input" type="text" name="price" value="{{old('price')}}">
                </div>
                @error('price')
                <div class="sell-form__error">
                    <p class="sell-form__error-message">{{$message}}</p>
                </div>
                @enderror
            </div>
        </div>
        <div class="sell-form__button">
            <button class="sell-form__submit" type="submit">出品する</button>
        </div>

    </form>
    
</div>
@endsection