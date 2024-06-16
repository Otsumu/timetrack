@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<main>
<form class="login-form" action="{{ route('login.post') }}" method="post">
@csrf
  <h2>ログイン</h2>
  @error('email')
  <p class=login-form__error-message> {{ $message }}</p>
  @enderror
    <input type="email" id="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
    @error('password')
    <p class=login-form__error-message> {{ $message }}</p>
    @enderror
    <input type="password" id="password" name="password" placeholder="パスワード" value="">

    <button class="login-btn" type="submit">ログイン</button>

  <div class="nohave">
    <h3>アカウントをお持ちでない方はこちらから<br>
    <span style="display: block; text-align: center;"><a href="{{ route('register') }}">会員登録</a></span></h3>
  </div>
</form>
</main>
@endsection