@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<main>
<form class="register-form" action="/auth/register" method="post">
@csrf
<h2>会員登録</h2>
@error('name')
<p class=register-form__error-message> {{ $message }}</p>
@enderror
  <input type="text" id="name" name="name" placeholder="名前" value="{{ old('name') }}">
 @error('email') 
 <p class=register-form__error-message> {{ $message }}</p>
 @enderror
  <input type="email" id="email" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
@error('password')
<p class=register-form__error-message> {{ $message }}</p>
@enderror  
  <input type="password" id="password" name="password" placeholder="パスワード">
@error('password_confirmation') 
<p class=register-form__error-message> {{ $message }}</p>
@enderror 
  <input type="password" id="password_confirmation" name="password_confirmation" placeholder="確認パスワード">
  <button class="register-btn" type="submit">会員登録</button>

   <div class="have-account">
    <h3>アカウントをお持ちの方はこちらから<br>
        <span style="display: block; text-align: center;"><a href="/login">ログイン</a></span></h3>
   </div>
</form>
</main>
@endsection