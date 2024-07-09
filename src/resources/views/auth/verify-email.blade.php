@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<main>  
    <div class="header__wrap">
        <div class="header__text">
            {{ ('メールアドレスをご確認下さい') }}
        </div>
    </div>
    <div class="body__wrap">
        @if(session('resent'))
        <div class="alert-seccess" role="alert">
            {{ ('ご登録頂きましたメールアドレスに確認用のリンクをお送りしました' )}}
        </div>
        @endif

        <p class="body__text">{{ ('メールをご確認下さい') }}</p>
        <p class="body__text">{{ ('もし確認用メールが届いていない場合は下記をクリックして下さい') }}</p>
        <form class="verify-email-form" action={{ route('verification.send') }} mathod="post">
          @csrf
          <button class="verify-email-btn" type="submit">{{ ('確認メールを再送する') }}</button>
        </form>

        <a class="back__button" href="{{ route('logout') }}">戻る</a>
    </div>
</main>
@endsection
