@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<main>  
    <div class="header__wrap">
        <div class="header__text">
            {{ __('登録されたメールアドレスをご確認下さい。') }}
        @if(session('resent'))
          <h2 class="alert-success" role="alert">
            {{ __('ご登録頂きましたメールアドレスに確認用のリンクをお送りしました') }}
          </h2>
        @endif
        </div>
        <div class="body__wrap">
        <p class="body__text">{!! __('メールをご確認下さい。<br>もし確認用メールが届いていない場合は下記をクリックして下さい！') !!}</p>
        <form class="verify-email-form" action="{{ route('verification.send') }}" method="post">
          @csrf
          <button class="verify-email-btn" type="submit">{{ __('確認メールを再送信する') }}</button>
        </form>
        </div>
    </div>
</main>
@endsection
