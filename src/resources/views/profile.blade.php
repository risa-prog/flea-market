@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection

@section('content')
<div class="profile-form">
    <div class="profile-form__ttl">
            <h2>プロフィール設定</h2>
    </div>
    <div class="profile-img-form">
        <form action="/mypage/profile_img" enctype="multipart/form-data" method="post">
        @csrf
            <div class="profile-img-form__img">
                <div class="profile-img-form__content">
                    <input class="profile-form-img__input" type="file" name="profile_image" value="{{optional($member)['profile_image']}}">
                </div>
                <div class="profile-img-form__button">
                    <button class="profile-form-img__submit">画像を選択する</button>
                </div>
            </div>
            <div class="profile-form__error">
                    @error('profile_image')
                    <p class="profile-form__error-message">{{$message}}</p>
                    @enderror
            </div>
        </form>
        <form action="/mypage/profile" method="post">
            @csrf
            <div class="profile-form__group">
                <label class="profile-form__label">ユーザー名</label>
                <div class="profile-form__item">
                    <input class="profile-form__input" type="text" name="user_name" value="{{optional($member)->user_name}}">
                </div>
                <div class="profile-form__error">
                    @error('user_name')
                    <p class="profile-form__error-message">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label">郵便番号</label>
                <div class="profile-form__item">
                    <input class="profile-form__input" type="text" name="post_code" value="{{optional($member)->post_code}}">
                </div>
                <div class="profile-form__error">
                    @error('post_code')
                    <p class="profile-form__error-message">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label">住所</label>
                <div class="profile-form__item">
                    <input class="profile-form__input" type="text" name="address" value="{{optional($member)->address}}">
                </div>
                <div class="profile-form__error">
                    @error('address')
                    <p class="profile-form__error-message">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label">建物名</label>
                <div class="profile-form__item">
                    <input class="profile-form__input" type="text" name="building" value="{{optional($member)->building}}">
                </div>
                <div class="profile-form__error">
                    @error('building')
                    <p class="profile-form__error-message">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <input type="hidden" name="user_id" value="{{Auth::id()}}">
            <input type="hidden" name="id" value="{{optional($member)['id']}}">
            <div class="profile-form__button">
                <button class="profile-form__submit" type="submit">更新する</button>
            </div>
        </form>
    </div>
</div>



@endsection