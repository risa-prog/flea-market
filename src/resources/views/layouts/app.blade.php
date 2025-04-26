@extends('layouts.default')

@section('header')
<div class="search-form">
    <form action="/search/item" method="get">
        @csrf
        <input class="search-form__input" type="text" name="keyword" placeholder="なにをお探しですか？">
        <button class="search-form__submit">検索</button>
    </form>
</div>
<nav class="nav">
    @if (Auth::check())
    <div class="header__nav-logout">
        <form action="/logout" method="post">
            @csrf
            <button class="header__nav-logout-button" type="submit">ログアウト</button>
        </form>
    </div>
    @else
    <div class="header__nav-login">
        <a class="header__nav-login-link" href="/login">ログイン</a>
    </div>
    @endif
    <div class="header__nav-mypage">
        <a class="header__nav-mypage-link" href="/mypage">マイページ</a>
    </div>
    <div class="header__nav-sell">
        <a class="header__nav-sell-link" href="/sell">出品</a>
    </div>
</nav>
@endsection
    
